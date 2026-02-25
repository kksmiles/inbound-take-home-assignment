import { useState } from 'react'
import { Link as RouterLink } from 'react-router-dom'
import {
  Box,
  Card,
  Image,
  Heading,
  Text,
  Stack,
  Badge,
  HStack,
} from '@chakra-ui/react'
import type { Movie } from '../../api/movies'
import { FavoriteButton } from '../favorites/FavoriteButton'

interface MovieCardProps {
  movie: Movie
}

export function MovieCard({ movie }: MovieCardProps) {
  const [imageError, setImageError] = useState(false)
  const hasPoster = Boolean(
    movie.poster_url && movie.poster_url !== 'N/A' && !imageError
  )

  return (
    <Card.Root height="100%" overflow="hidden" bg="white" asChild>
      <RouterLink to={`/movies/${movie.imdb_id}`}>
        <>
          {hasPoster ? (
            <Image
              src={movie.poster_url ?? undefined}
              alt={movie.title}
              objectFit="cover"
              height="320px"
              width="100%"
              onError={() => setImageError(true)}
            />
          ) : (
            <Box
              height="320px"
              width="100%"
              bg="gray.200"
              display="flex"
              alignItems="center"
              justifyContent="center"
            >
              <Text color="gray.500" fontSize="sm">
                No poster available
              </Text>
            </Box>
          )}

          <Card.Body>
            <Stack gap={2}>
              <HStack justify="space-between" align="start">
                <Heading size="sm">{movie.title}</Heading>
                <FavoriteButton
                  imdbId={movie.imdb_id}
                  initialIsFavorited={movie.is_favorited}
                />
              </HStack>

              <Stack direction="row" gap={2} align="center">
                {movie.year && (
                  <Badge colorScheme="blue" variant="subtle">
                    {movie.year}
                  </Badge>
                )}
                {movie.type && (
                  <Badge
                    colorScheme="purple"
                    variant="outline"
                    textTransform="capitalize"
                  >
                    {movie.type}
                  </Badge>
                )}
              </Stack>

              <Text fontSize="xs" color="gray.400">
                IMDb ID: {movie.imdb_id}
              </Text>
            </Stack>
          </Card.Body>
        </>
      </RouterLink>
    </Card.Root>
  )
}
