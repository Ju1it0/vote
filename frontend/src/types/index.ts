export interface User {
  id: number;
  name: string;
  lastname: string;
  email: string;
  email_verified_at: string;
  created_at: string;
  updated_at: string;
}

export interface Voter {
  id: number;
  document: string;
  name: string;
  lastname: string;
  dob: string;
  isCandidate: boolean;
  address: string | null;
  phone: string | null;
  gender: 'M' | 'F' | 'O' | null;
  created_at: string;
  updated_at: string;
}

export interface Vote {
  id: number;
  voter_id: number;
  candidate_id: number;
  created_at: string;
  updated_at: string;
  voter: Voter;
  candidate: Voter;
}

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface AuthResponse {
  user: User;
  token: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
} 