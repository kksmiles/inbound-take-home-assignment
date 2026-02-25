import { Routes, Route } from 'react-router-dom'
import HealthCheck from './pages/HealthCheck'
import Movies from './pages/Movies'
import Login from './pages/Login'
import Register from './pages/Register'
// import MovieDetail from "./pages/MovieDetail"

function App() {
  return (
    <Routes>
      <Route path="/" element={<Movies />} />
      <Route path="/movies" element={<Movies />} />
      <Route path="/healthcheck" element={<HealthCheck />} />
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      {/* <Route path="/movies" element={<Movies />} />
      <Route path="/movies/:movieId" element={<MovieDetail />} /> */}
    </Routes>
  )
}

export default App
