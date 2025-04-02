import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { voteService } from '../services/api';

interface Candidate {
  id: number;
  name: string;
  lastname: string;
  document: string;
}

const VotePage: React.FC = () => {
  const navigate = useNavigate();
  const [document, setDocument] = useState('');
  const [candidates, setCandidates] = useState<Candidate[]>([]);
  const [selectedCandidate, setSelectedCandidate] = useState<number | null>(null);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCandidates();
  }, []);

  const fetchCandidates = async () => {
    try {
      setLoading(true);
      const data = await voteService.getCandidates();
      setCandidates(data);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al cargar los candidatos');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setSuccess('');
    setLoading(true);

    try {
      const response = await voteService.submitVote(document, selectedCandidate!);
      setSuccess(response.message);
      setSelectedCandidate(null);
      setDocument('');
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al registrar el voto');
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-100 flex items-center justify-center">
        <div className="text-xl">Cargando candidatos...</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
      <div className="relative py-3 sm:max-w-xl sm:mx-auto">
        <div className="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
          <div className="max-w-md mx-auto">
            <div className="divide-y divide-gray-200">
              <div className="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                <h2 className="text-2xl font-bold mb-8 text-center">Sistema de Votación</h2>
                
                <form onSubmit={handleSubmit} className="space-y-6">
                  <div>
                    <label className="block text-sm font-medium text-gray-700">
                      Documento de Identidad
                    </label>
                    <input
                      type="text"
                      value={document}
                      onChange={(e) => setDocument(e.target.value)}
                      className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                      required
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Seleccione su candidato
                    </label>
                    <select
                      value={selectedCandidate || ''}
                      onChange={(e) => setSelectedCandidate(Number(e.target.value))}
                      className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                      required
                    >
                      <option value="">Seleccione un candidato</option>
                      {candidates.map((candidate) => (
                        <option key={candidate.id} value={candidate.id}>
                          {candidate.name} {candidate.lastname}
                        </option>
                      ))}
                    </select>
                  </div>

                  {error && (
                    <div className="text-red-600 text-sm">{error}</div>
                  )}

                  {success && (
                    <div className="text-green-600 text-sm">{success}</div>
                  )}

                  <div className="flex justify-between">
                    <button
                      type="submit"
                      className="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                      Votar
                    </button>
                    <button
                      type="button"
                      onClick={() => navigate('/admin/top-candidates')}
                      className="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    >
                      Gestionar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default VotePage; 