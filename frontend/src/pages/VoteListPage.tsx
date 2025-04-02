import React, { useState, useEffect } from 'react';
import { voteService, voterService } from '../services/api';
import { Vote, Voter, PaginatedResponse } from '../types';

const VoteListPage: React.FC = () => {
  const [votes, setVotes] = useState<Vote[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [selectedVote, setSelectedVote] = useState<Vote | null>(null);
  const [voterDetails, setVoterDetails] = useState<Voter | null>(null);
  const [candidateDetails, setCandidateDetails] = useState<Voter | null>(null);
  const [loadingDetails, setLoadingDetails] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [total, setTotal] = useState(0);
  const [mostVotedCandidate, setMostVotedCandidate] = useState<{ candidate: Voter; totalVotes: number } | null>(null);
  const [loadingMostVoted, setLoadingMostVoted] = useState(true);

  useEffect(() => {
    loadVotes(currentPage);
    loadMostVotedCandidate();
  }, [currentPage]);

  const loadVotes = async (page: number) => {
    try {
      const response: PaginatedResponse<Vote> = await voteService.getAll(page);
      setVotes(response.data);
      setLastPage(response.last_page);
      setTotal(response.total);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al cargar la lista de votos');
    } finally {
      setLoading(false);
    }
  };

  const loadMostVotedCandidate = async () => {
    setLoadingMostVoted(true);
    try {
      const data = await voteService.getMostVotedCandidate();
      setMostVotedCandidate(data);
    } catch (err: any) {
      console.error('Error al cargar el candidato más votado:', err);
    } finally {
      setLoadingMostVoted(false);
    }
  };

  const loadVoteDetails = async (vote: Vote) => {
    setSelectedVote(vote);
    setLoadingDetails(true);
    try {
      const [voterData, candidateData] = await Promise.all([
        voterService.getById(vote.voter.id),
        vote.candidate ? voterService.getById(vote.candidate.id) : null
      ]);
      setVoterDetails(voterData);
      setCandidateDetails(candidateData);
    } catch (err: any) {
      console.error('Error al cargar detalles:', err);
    } finally {
      setLoadingDetails(false);
    }
  };

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    setLoading(true);
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-100 flex items-center justify-center">
        <div className="text-xl">Cargando votos...</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-100 py-6">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-6">Votos</h1>

        {/* Componente del candidato más votado */}
        <div className="bg-white shadow rounded-lg p-6 mb-6">
          <h2 className="text-xl font-semibold text-gray-900 mb-4">Candidato más votado</h2>
          {loadingMostVoted ? (
            <div className="text-center py-4">Cargando candidato más votado...</div>
          ) : mostVotedCandidate?.candidate ? (
            <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-lg font-medium text-blue-900">
                    {mostVotedCandidate.candidate.name} {mostVotedCandidate.candidate.lastname}
                  </p>
                  <p className="text-sm text-blue-700">
                    Documento: {mostVotedCandidate.candidate.document}
                  </p>
                </div>
                <div className="text-2xl font-bold text-blue-600">
                  {mostVotedCandidate.totalVotes} votos
                </div>
              </div>
            </div>
          ) : (
            <div className="text-center py-4 text-gray-500">
              No hay votos registrados
            </div>
          )}
        </div>

        {error && (
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {error}
          </div>
        )}

        <div className="bg-white shadow overflow-hidden sm:rounded-md">
          <div className="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div className="grid grid-cols-4 gap-4">
              <div className="col-span-1 text-sm font-medium text-gray-500">Votante</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Candidato</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Fecha</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Hora</div>
            </div>
          </div>
          <ul className="divide-y divide-gray-200">
            {votes.length > 0 ? (
              votes.map((vote) => (
                <li key={vote.id} className="hover:bg-gray-50 cursor-pointer" onClick={() => loadVoteDetails(vote)}>
                  <div className="px-4 py-4">
                    <div className="grid grid-cols-4 gap-4 items-center">
                      <div className="col-span-1 text-sm font-medium text-gray-900">
                        {vote.voter.name} {vote.voter.lastname}
                      </div>
                      <div className="col-span-1 text-sm text-gray-500">
                        {vote.candidate ? `${vote.candidate.name} ${vote.candidate.lastname}` : 'Voto en blanco'}
                      </div>
                      <div className="col-span-1 text-sm text-gray-500">
                        {new Date(vote.created_at).toLocaleDateString()}
                      </div>
                      <div className="col-span-1 text-sm text-gray-500">
                        {new Date(vote.created_at).toLocaleTimeString()}
                      </div>
                    </div>
                  </div>
                </li>
              ))
            ) : (
              <li className="px-4 py-4">
                <div className="text-center text-gray-500">
                  No hay votos registrados
                </div>
              </li>
            )}
          </ul>
        </div>

        {/* Paginación */}
        <div className="mt-4 flex justify-center">
          <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <button
              onClick={() => handlePageChange(currentPage - 1)}
              disabled={currentPage === 1}
              className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Anterior
            </button>
            
            {[...Array(lastPage)].map((_, index) => (
              <button
                key={index + 1}
                onClick={() => handlePageChange(index + 1)}
                className={`relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                  currentPage === index + 1
                    ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                }`}
              >
                {index + 1}
              </button>
            ))}

            <button
              onClick={() => handlePageChange(currentPage + 1)}
              disabled={currentPage === lastPage}
              className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Siguiente
            </button>
          </nav>
        </div>

        <div className="mt-2 text-center text-sm text-gray-500">
          Mostrando {votes.length} de {total} votos
        </div>
      </div>

      {/* Modal de detalles */}
      {selectedVote && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
          <div className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <h3 className="text-lg font-medium text-gray-900 mb-4">Detalles del Voto</h3>
              
              {loadingDetails ? (
                <div className="text-center py-4">Cargando detalles...</div>
              ) : (
                <>
                  <div className="mb-6">
                    <h4 className="font-semibold text-gray-700 mb-2">Información del Votante</h4>
                    {voterDetails && (
                      <div className="space-y-2 text-sm">
                        <p><span className="font-medium">Nombre completo:</span> {voterDetails.name} {voterDetails.lastname}</p>
                        <p><span className="font-medium">Documento:</span> {voterDetails.document}</p>
                        <p><span className="font-medium">Fecha de nacimiento:</span> {new Date(voterDetails.dob).toLocaleDateString()}</p>
                        <p><span className="font-medium">Fecha de voto:</span> {new Date(selectedVote.created_at).toLocaleString()}</p>
                      </div>
                    )}
                  </div>

                  <div>
                    <h4 className="font-semibold text-gray-700 mb-2">Información del Candidato</h4>
                    {candidateDetails ? (
                      <div className="space-y-2 text-sm">
                        <p><span className="font-medium">Nombre completo:</span> {candidateDetails.name} {candidateDetails.lastname}</p>
                        <p><span className="font-medium">Documento:</span> {candidateDetails.document}</p>
                        <p><span className="font-medium">Fecha de nacimiento:</span> {new Date(candidateDetails.dob).toLocaleDateString()}</p>
                      </div>
                    ) : (
                      <p className="text-sm text-gray-500">Voto en blanco</p>
                    )}
                  </div>
                </>
              )}

              <div className="mt-6">
                <button
                  onClick={() => setSelectedVote(null)}
                  className="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default VoteListPage; 