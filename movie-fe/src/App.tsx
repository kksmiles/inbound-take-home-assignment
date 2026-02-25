import { Routes, Route, Navigate, Outlet } from 'react-router-dom'
import HealthCheck from './pages/HealthCheck'
import Movies from './pages/Movies'
import Login from './pages/Login'
import Register from './pages/Register'
import MovieDetail from './pages/MovieDetail.tsx'
import { NavBar } from './components/layout/NavBar'
import { isAuthenticated } from './helpers/session'

function GuestOnlyRoute() {
  if (isAuthenticated()) {
    return <Navigate to="/" replace />
  }

  return <Outlet />
}

function AuthenticatedRoute() {
  // Currently No Logic Needed

  return <Outlet />
}

function App() {
  return (
    <>
      <NavBar />
      <Routes>
        <Route element={<AuthenticatedRoute />}>
          <Route path="/" element={<Movies />} />
          <Route path="/movies" element={<Movies />} />
          <Route path="/movies/:imdbId" element={<MovieDetail />} />
          <Route path="/healthcheck" element={<HealthCheck />} />
        </Route>

        <Route element={<GuestOnlyRoute />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>
      </Routes>
    </>
  )
}

export default App
