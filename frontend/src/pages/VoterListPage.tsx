import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { voterService } from '../services/api';
import { Voter, PaginatedResponse } from '../types';

const VoterListPage: React.FC = () => {
  const [voters, setVoters] = useState<Voter[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [total, setTotal] = useState(0);

  useEffect(() => {
    loadVoters(currentPage);
  }, [currentPage]);

  const loadVoters = async (page: number) => {
    try {
      const response: PaginatedResponse<Voter> = await voterService.getAll(page);
      setVoters(response.data);
      setLastPage(response.last_page);
      setTotal(response.total);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al cargar la lista de votantes');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id: number) => {
    if (!window.confirm('¿Está seguro de eliminar este votante?')) {
      return;
    }

    try {
      await voterService.delete(id);
      loadVoters(currentPage);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al eliminar el votante');
    }
  };

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    setLoading(true);
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-100 flex items-center justify-center">
        <div className="text-xl">Cargando votantes...</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-100 py-6">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-3xl font-bold text-gray-900">Votantes</h1>
          <Link
            to="/admin/voters/new"
            className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
          >
            Nuevo Votante
          </Link>
        </div>

        {error && (
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {error}
          </div>
        )}

        <div className="bg-white shadow overflow-hidden sm:rounded-md">
          <div className="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div className="grid grid-cols-8 gap-4">
              <div className="col-span-2 text-sm font-medium text-gray-500">Nombre</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Documento</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Teléfono</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Fecha de Nacimiento</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Tipo</div>
              <div className="col-span-2 text-sm font-medium text-gray-500">Acciones</div>
            </div>
          </div>
          <ul className="divide-y divide-gray-200">
            {voters.map((voter) => (
              <li key={voter.id}>
                <div className="px-4 py-4">
                  <div className="grid grid-cols-8 gap-4 items-center">
                    <div className="col-span-2 text-sm font-medium text-gray-900">
                      {voter.name} {voter.lastname}
                    </div>
                    <div className="col-span-1 text-sm text-gray-500">
                      {voter.document}
                    </div>
                    <div className="col-span-1 text-sm text-gray-500">
                      {voter.phone || 'No especificado'}
                    </div>
                    <div className="col-span-1 text-sm text-gray-500">
                      {voter.dob ? new Date(voter.dob).toLocaleDateString() : 'No especificado'}
                    </div>
                    <div className="col-span-1">
                      <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                        voter.isCandidate
                          ? 'bg-green-100 text-green-800'
                          : 'bg-blue-100 text-blue-800'
                      }`}>
                        {voter.isCandidate ? 'Candidato' : 'Votante'}
                      </span>
                    </div>
                    <div className="col-span-2 flex space-x-2">
                      <Link
                        to={`/admin/voters/${voter.id}/edit`}
                        className="inline-flex items-center px-3 py-1 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50"
                      >
                        Editar
                      </Link>
                      <button
                        onClick={() => handleDelete(voter.id)}
                        className="inline-flex items-center px-3 py-1 border border-red-600 text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50"
                      >
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              </li>
            ))}
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
          Mostrando {voters.length} de {total} votantes
        </div>
      </div>
    </div>
  );
};

export default VoterListPage; 