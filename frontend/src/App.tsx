import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { ThemeProvider, createTheme, CssBaseline } from '@mui/material';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { AuthProvider } from './contexts/AuthContext';
import { LoginPage } from './pages/LoginPage';
import VotePage from './pages/VotePage';
import VoterListPage from './pages/VoterListPage';
import VoterFormPage from './pages/VoterFormPage';
import VoteListPage from './pages/VoteListPage';
import TopCandidatesPage from './pages/TopCandidatesPage';
import PrivateRoute from './components/PrivateRoute';
import ChangePasswordPage from './pages/ChangePasswordPage';

const theme = createTheme({
  palette: {
    mode: 'light',
    primary: {
      main: '#1976d2',
    },
    secondary: {
      main: '#dc004e',
    },
  },
});

const queryClient = new QueryClient();

function ProtectedRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Navigate to="/top-candidates" replace />} />
      <Route path="/voters" element={<VoterListPage />} />
      <Route path="/voters/new" element={<VoterFormPage />} />
      <Route path="/voters/:id/edit" element={<VoterFormPage />} />
      <Route path="/votes" element={<VoteListPage />} />
      <Route path="/top-candidates" element={<TopCandidatesPage />} />
      <Route path="/change-password" element={<ChangePasswordPage />} />
    </Routes>
  );
}

function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Navigate to="/vote" replace />} />
      <Route path="/vote" element={<VotePage />} />
      <Route path="/login" element={<LoginPage />} />
      <Route
        path="/admin/*"
        element={
          <PrivateRoute>
            <ProtectedRoutes />
          </PrivateRoute>
        }
      />
      <Route path="*" element={<Navigate to="/vote" replace />} />
    </Routes>
  );
}

function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <ThemeProvider theme={theme}>
        <CssBaseline />
        <AuthProvider>
          <Router>
            <AppRoutes />
          </Router>
        </AuthProvider>
      </ThemeProvider>
    </QueryClientProvider>
  );
}

export default App;
