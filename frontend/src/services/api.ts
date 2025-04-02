import axios from 'axios';
import { AuthResponse, LoginCredentials, Voter, Vote, PaginatedResponse } from '../types';
import { API_URL } from '../utils/constants';

export const publicApi = axios.create({
  baseURL: API_URL,
});

export const protectedApi = axios.create({
  baseURL: API_URL,
});

protectedApi.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

interface ChangePasswordData {
  current_password: string;
  password: string;
  password_confirmation: string;
}

export const authService = {
  login: async (credentials: LoginCredentials): Promise<AuthResponse> => {
    const response = await publicApi.post<AuthResponse>('/api/login', credentials);
    if (response.data.token) {
      localStorage.setItem('token', response.data.token);
    }
    return response.data;
  },

  logout: async (): Promise<void> => {
    await protectedApi.post('/api/logout');
    localStorage.removeItem('token');
  },

  getUser: async () => {
    const response = await protectedApi.get('/api/user');
    return response.data;
  },

  changePassword: async (data: ChangePasswordData): Promise<void> => {
    const response = await protectedApi.put('/api/password', data);
    return response.data;
  },
};

export const voterService = {
  getAll: async (page: number = 1): Promise<PaginatedResponse<Voter>> => {
    const response = await protectedApi.get<PaginatedResponse<Voter>>(`/api/voters?page=${page}`);
    return response.data;
  },
  getTopCandidates: async (): Promise<{ data: (Voter & { totalVotes: number })[] }> => {
    const response = await publicApi.get<{ data: (Voter & { totalVotes: number })[] }>('/api/candidates/top');
    return response.data;
  },
  getById: async (id: number): Promise<Voter> => {
    const response = await protectedApi.get<Voter>(`/api/voters/${id}`);
    return response.data;
  },
  create: async (voter: Omit<Voter, 'id' | 'created_at' | 'updated_at'>): Promise<Voter> => {
    const response = await protectedApi.post<Voter>('/api/voters', voter);
    return response.data;
  },
  update: async (id: number, voter: Partial<Voter>): Promise<Voter> => {
    const response = await protectedApi.put<Voter>(`/api/voters/${id}`, voter);
    return response.data;
  },
  delete: async (id: number): Promise<void> => {
    await protectedApi.delete(`/api/voters/${id}`);
  },
};
export const voteService = {
  getAll: async (page: number = 1): Promise<PaginatedResponse<Vote>> => {
    const response = await protectedApi.get<PaginatedResponse<Vote>>(`/api/votes?page=${page}`);
    return response.data;
  },
  getMostVotedCandidate: async (): Promise<{ candidate: Voter; totalVotes: number }> => {
    const response = await protectedApi.get<{ candidate: Voter; totalVotes: number }>('/api/votes/most-voted');
    return response.data;
  },
  create: async (vote: { document: string; candidateId: number }): Promise<{ message: string }> => {
    const response = await publicApi.post<{ message: string }>('/api/votes', vote);
    return response.data;
  },
  getCandidates: async (): Promise<Voter[]> => {
    const response = await publicApi.get<Voter[]>('/api/candidates');
    return response.data;
  },
  submitVote: async (document: string, candidateId: number): Promise<{ message: string }> => {
    const response = await publicApi.post<{ message: string }>('/api/votes', {
      document,
      candidateId,
    });
    return response.data;
  },
};