export interface Movie {
  imdb_id: string
  title: string
  year: string | null
  type: string | null
  poster_url: string | null
  details?: Record<string, unknown> | null
  is_favorited?: boolean
}

export interface MovieSearchResponse {
  data: Movie[]
  meta: {
    total: number
    current_page: number
    per_page: number
    source: string
  }
}

import { API_BASE_URL, apiFetch, handleJsonResponse } from './client'

export async function fetchRecentMovies(): Promise<Movie[]> {
  const res = await apiFetch(`${API_BASE_URL}/movies`)
  const json = await handleJsonResponse<{ data: Movie[] }>(res)
  return json.data
}

export async function searchMovies(
  query: string,
  page: number = 1
): Promise<MovieSearchResponse> {
  const params = new URLSearchParams({
    q: query,
    page: String(page),
  })

  const res = await apiFetch(
    `${API_BASE_URL}/movies/search?${params.toString()}`
  )
  const json = await handleJsonResponse<MovieSearchResponse>(res)
  return json
}

export async function fetchMovieById(imdbId: string): Promise<Movie> {
  const res = await apiFetch(
    `${API_BASE_URL}/movies/${encodeURIComponent(imdbId)}`
  )
  const json = await handleJsonResponse<{ data: Movie }>(res)
  return json.data
}
