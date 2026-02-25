import type { ReactNode } from 'react'
import { Box, SimpleGrid, Text, Spinner, Center, Stack } from '@chakra-ui/react'
import type { Movie } from '../../api/movies'
import { MovieCard } from './MovieCard'

interface MovieGridProps {
  movies: Movie[]
  isLoading: boolean
  isSearching: boolean
  error?: string | null
  emptyMessage?: ReactNode
}

export function MovieGrid({
  movies,
  isLoading,
  isSearching,
  error,
  emptyMessage,
}: MovieGridProps) {
  if (isLoading) {
    return (
      <Center py={16}>
        <Stack align="center" gap={3}>
          <Spinner size="lg" />
          <Text color="gray.500">
            {isSearching ? 'Searching movies...' : 'Loading recent movies...'}
          </Text>
        </Stack>
      </Center>
    )
  }

  if (error) {
    return (
      <Center py={16}>
        <Text color="red.500">Failed to load movies: {error}</Text>
      </Center>
    )
  }

  if (movies.length === 0) {
    return (
      <Center py={16}>
        <Text color="gray.500">
          {emptyMessage ?? 'No movies to display yet.'}
        </Text>
      </Center>
    )
  }

  return (
    <Box>
      <SimpleGrid columns={{ base: 2, md: 3, lg: 5 }} gap={6}>
        {movies.map((movie) => (
          <MovieCard key={movie.imdb_id} movie={movie} />
        ))}
      </SimpleGrid>
    </Box>
  )
}
