import axios from 'axios';
import { AuthResponse, LoginCredentials, Voter, Vote, DashboardStats } from '../types';

const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
  },
});

// Interceptor para agregar el token a las peticiones
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Servicios de autenticación
export const authService = {
  login: async (credentials: LoginCredentials): Promise<AuthResponse> => {
    const response = await api.post<AuthResponse>('/login', credentials);
    localStorage.setItem('token', response.data.token);
    return response.data;
  },

  logout: async (): Promise<void> => {
    await api.post('/logout');
    localStorage.removeItem('token');
  },

  getUser: async () => {
    const response = await api.get('/user');
    return response.data;
  },
};

// Servicios de votantes
export const voterService = {
  getAll: async (): Promise<Voter[]> => {
    const response = await api.get<Voter[]>('/voters');
    return response.data;
  },

  getById: async (id: number): Promise<Voter> => {
    const response = await api.get<Voter>(`/voters/${id}`);
    return response.data;
  },

  create: async (voter: Omit<Voter, 'id' | 'created_at' | 'updated_at'>): Promise<Voter> => {
    const response = await api.post<Voter>('/voters', voter);
    return response.data;
  },

  update: async (id: number, voter: Partial<Voter>): Promise<Voter> => {
    const response = await api.put<Voter>(`/voters/${id}`, voter);
    return response.data;
  },

  delete: async (id: number): Promise<void> => {
    await api.delete(`/voters/${id}`);
  },
};

// Servicios de votos
export const voteService = {
  getAll: async (): Promise<Vote[]> => {
    const response = await api.get<Vote[]>('/votes');
    return response.data;
  },

  getById: async (id: number): Promise<Vote> => {
    const response = await api.get<Vote>(`/votes/${id}`);
    return response.data;
  },

  create: async (vote: { document: string; candidateId: number }): Promise<{ message: string }> => {
    const response = await api.post<{ message: string }>('/votes', vote);
    return response.data;
  },
};

// Servicios del dashboard
export const dashboardService = {
  getStats: async (): Promise<DashboardStats> => {
    const response = await api.get<DashboardStats>('/dashboard');
    return response.data;
  },
}; 