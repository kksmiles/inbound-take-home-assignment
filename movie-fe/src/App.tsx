import { Routes, Route } from 'react-router-dom'
import HealthCheck from './pages/HealthCheck'
// import Movies from "./pages/Movies"
// import MovieDetail from "./pages/MovieDetail"

function App() {
  return (
    <Routes>
      <Route path="/" element={<HealthCheck />} />
      <Route path="/healthcheck" element={<HealthCheck />} />
      {/* <Route path="/movies" element={<Movies />} />
      <Route path="/movies/:movieId" element={<MovieDetail />} /> */}
    </Routes>
  )
}

export default App
