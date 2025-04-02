import React, { useState, useEffect } from 'react';
import { voterService } from '../services/api';
import { Voter } from '../types';

interface CandidateWithVotes extends Voter {
  received_votes_count: number;
}

const TopCandidatesPage: React.FC = () => {
  const [candidates, setCandidates] = useState<CandidateWithVotes[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    loadCandidates();
  }, []);

  const loadCandidates = async () => {
    try {
      const response = await voterService.getTopCandidates();
      setCandidates(response.data);
    } catch (err) {
      console.error('Error al cargar candidatos:', err);
      setError('Error al cargar la lista de candidatos');
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
    <div className="min-h-screen bg-gray-100 py-6">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-6">Candidatos más votados</h1>

        {error && (
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {error}
          </div>
        )}

        <div className="bg-white shadow overflow-hidden sm:rounded-md">
          <div className="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div className="grid grid-cols-4 gap-4">
              <div className="col-span-1 text-sm font-medium text-gray-500">Posición</div>
              <div className="col-span-2 text-sm font-medium text-gray-500">Candidato</div>
              <div className="col-span-1 text-sm font-medium text-gray-500">Total de votos</div>
            </div>
          </div>
          <ul className="divide-y divide-gray-200">
            {candidates.map((candidate, index) => (
              <li key={candidate.id}>
                <div className="px-4 py-4">
                  <div className="grid grid-cols-4 gap-4 items-center">
                    <div className="col-span-1 text-sm font-medium text-gray-900">
                      #{index + 1}
                    </div>
                    <div className="col-span-2">
                      <div className="text-sm font-medium text-gray-900">
                        {candidate.name} {candidate.lastname}
                      </div>
                      <div className="text-sm text-gray-500">
                        Documento: {candidate.document}
                      </div>
                    </div>
                    <div className="col-span-1 text-sm text-gray-900 font-medium">
                      {candidate.received_votes_count}
                    </div>
                  </div>
                </div>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
};

export default TopCandidatesPage; 