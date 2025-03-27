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
  voterId: number;
  candidateId: number;
  date: string;
  created_at: string;
  updated_at: string;
  voter: {
    id: number;
    name: string;
    lastname: string;
    document: string;
  };
  candidate: {
    id: number;
    name: string;
    lastname: string;
  };
}

export interface DashboardStats {
  total_voters: number;
  total_votes: number;
  total_candidates: number;
  votes_by_candidate: Array<{
    candidate: string;
    total: number;
  }>;
}

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface AuthResponse {
  user: User;
  token: string;
} 