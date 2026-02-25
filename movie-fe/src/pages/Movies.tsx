import { useEffect, useState, useCallback } from 'react'
import {
  Box,
  Container,
  Heading,
  Stack,
  Text,
  HStack,
  Button,
} from '@chakra-ui/react'
import { type Movie, fetchRecentMovies, searchMovies } from '../api/movies'
import { MovieSearchBar } from '../components/movies/MovieSearchBar'
import { MovieGrid } from '../components/movies/MovieGrid'

const DEBOUNCE_MS = 500

function Movies() {
  const [movies, setMovies] = useState<Movie[]>([])
  const [loading, setLoading] = useState<boolean>(false)
  const [isSearching, setIsSearching] = useState<boolean>(false)
  const [query, setQuery] = useState<string>('')
  const [error, setError] = useState<string | null>(null)
  const [total, setTotal] = useState<number | null>(null)
  const [page, setPage] = useState<number>(1)
  const [totalPages, setTotalPages] = useState<number | null>(null)

  const fetchMovies = useCallback(
    async (searchQuery: string | null = null, currentPage: number = 1) => {
      setLoading(true)
      setError(null)

      try {
        if (searchQuery) {
          setIsSearching(true)
          const { data, meta } = await searchMovies(searchQuery, currentPage)
          setMovies(data)
          setTotal(meta.total)
          const perPage = meta.per_page || data.length || 10
          setTotalPages(Math.max(1, Math.ceil(meta.total / perPage)))
        } else {
          setIsSearching(false)
          setTotal(null)
          setTotalPages(null)
          const data = await fetchRecentMovies()
          setMovies(data)
        }
      } catch (err) {
        const message =
          err instanceof Error
            ? err.message
            : 'Unknown error while loading movies'
        setError(message)
      } finally {
        setLoading(false)
      }
    },
    []
  )

  useEffect(() => {
    // Initial load: fetch recent movies
    if (!query.trim()) {
      void fetchMovies()
    }
  }, [fetchMovies, query])

  useEffect(() => {
    const trimmedQuery = query.trim()

    const timeoutId = window.setTimeout(() => {
      if (!trimmedQuery) {
        // Handled by the first useEffect for initial load/reset
        return
      }
      void fetchMovies(trimmedQuery, page)
    }, DEBOUNCE_MS)

    return () => {
      window.clearTimeout(timeoutId)
    }
  }, [query, page, fetchMovies])

  return (
    <Container maxW="container.xl" py={10}>
      <Stack gap={8}>
        <Stack gap={3}>
          <HStack justify="space-between" align="center">
            <Box>
              <Heading size="lg">Movies</Heading>
            </Box>
          </HStack>

          <MovieSearchBar
            value={query}
            onChange={(value) => {
              setQuery(value)
              setPage(1)
            }}
          />

          <HStack justify="space-between" align="center">
            <Box>
              {query.trim() ? (
                <Text color="gray.500" mt={1}>
                  Showing results for &quot;{query}&quot;.
                </Text>
              ) : (
                <Text fontWeight={'bold'} color="black" mt={1}>
                  Recently Popular
                </Text>
              )}
            </Box>
          </HStack>

          {isSearching && total != null && !loading && (
            <Text fontSize="sm" color="gray.500">
              Found approximately {total.toLocaleString()} results for &quot;
              {query}&quot;.
            </Text>
          )}
        </Stack>

        <MovieGrid
          movies={movies}
          isLoading={loading}
          isSearching={isSearching}
          error={error}
          emptyMessage={
            isSearching ? (
              <span>No movies found. Try a different title.</span>
            ) : (
              <span>No movies yet. Try searching for a title.</span>
            )
          }
        />

        {query.trim() &&
          !loading &&
          !error &&
          totalPages !== null &&
          totalPages > 1 && (
            <HStack justify="center" gap={4}>
              <Button
                variant="outline"
                onClick={() => setPage((p) => Math.max(1, p - 1))}
                disabled={page <= 1}
              >
                Previous
              </Button>
              <Text fontSize="sm" color="gray.600">
                Page {page} of {totalPages}
              </Text>
              <Button
                variant="outline"
                onClick={() =>
                  setPage((p) =>
                    totalPages ? Math.min(totalPages, p + 1) : p + 1
                  )
                }
                disabled={totalPages !== null && page >= totalPages}
              >
                Next
              </Button>
            </HStack>
          )}
      </Stack>
    </Container>
  )
}

export default Movies
