import { useEffect, useState } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import {
  Box,
  Button,
  Container,
  Heading,
  HStack,
  Image,
  Stack,
  Text,
  Badge,
  Spinner,
} from '@chakra-ui/react'
import type { Movie } from '../api/movies'
import { fetchMovieById } from '../api/movies'
import { FavoriteButton } from '../components/favorites/FavoriteButton'

interface MovieWithDetails extends Movie {
  details?: {
    Plot?: string
    Genre?: string
    Director?: string
    Actors?: string
    Runtime?: string
    imdbRating?: string
    [key: string]: unknown
  } | null
}

function MovieDetail() {
  const navigate = useNavigate()
  const { imdbId } = useParams<{ imdbId: string }>()
  const [movie, setMovie] = useState<MovieWithDetails | null>(null)
  const [loading, setLoading] = useState<boolean>(true)
  const [error, setError] = useState<string | null>(null)
  const [imageError, setImageError] = useState(false)

  useEffect(() => {
    if (!imdbId) {
      setError('Invalid movie ID.')
      setLoading(false)
      return
    }

    const run = async () => {
      setLoading(true)
      setError(null)

      try {
        const data = await fetchMovieById(imdbId)
        setMovie(data)
      } catch (err) {
        const message =
          err instanceof Error ? err.message : 'Failed to load movie details.'
        setError(message)
      } finally {
        setLoading(false)
      }
    }

    void run()
  }, [imdbId])

  const handleBack = () => {
    navigate(-1)
  }

  if (loading) {
    return (
      <Container maxW="container.md" py={10}>
        <HStack justify="center" gap={3}>
          <Spinner />
          <Text>Loading movie details...</Text>
        </HStack>
      </Container>
    )
  }

  if (error || !movie) {
    return (
      <Container maxW="container.md" py={10}>
        <Stack gap={4}>
          <Button variant="outline" onClick={handleBack}>
            Back to movies
          </Button>
          <Text color="red.500">{error ?? 'Movie not found.'}</Text>
        </Stack>
      </Container>
    )
  }

  const hasPoster =
    movie.poster_url && movie.poster_url !== 'N/A' && !imageError

  return (
    <Container maxW="container.lg" py={10}>
      <Stack gap={6}>
        <HStack justify="space-between" align="center">
          <Button variant="outline" onClick={handleBack} alignSelf="flex-start">
            Back to movies
          </Button>
          <FavoriteButton
            imdbId={movie.imdb_id}
            size="md"
            initialIsFavorited={movie.is_favorited}
          />
        </HStack>

        <HStack align="flex-start" gap={8} flexWrap="wrap">
          <Box flex="0 0 260px">
            {hasPoster ? (
              <Image
                src={movie.poster_url ?? undefined}
                alt={movie.title}
                objectFit="cover"
                width="100%"
                maxHeight="400px"
                onError={() => setImageError(true)}
              />
            ) : (
              <Box
                height="400px"
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
          </Box>

          <Box flex="1">
            <Stack gap={3}>
              <Heading>{movie.title}</Heading>

              <HStack gap={2}>
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
                <Badge colorScheme="gray" variant="outline">
                  IMDb ID: {movie.imdb_id}
                </Badge>
              </HStack>

              {movie.details?.Genre && (
                <Text>
                  <Text as="span" fontWeight="semibold">
                    Genre:
                  </Text>{' '}
                  {movie.details.Genre}
                </Text>
              )}

              {movie.details?.Director && (
                <Text>
                  <Text as="span" fontWeight="semibold">
                    Director:
                  </Text>{' '}
                  {movie.details.Director}
                </Text>
              )}

              {movie.details?.Actors && (
                <Text>
                  <Text as="span" fontWeight="semibold">
                    Cast:
                  </Text>{' '}
                  {movie.details.Actors}
                </Text>
              )}

              {movie.details?.Runtime && (
                <Text>
                  <Text as="span" fontWeight="semibold">
                    Runtime:
                  </Text>{' '}
                  {movie.details.Runtime}
                </Text>
              )}

              {movie.details?.imdbRating && (
                <Text>
                  <Text as="span" fontWeight="semibold">
                    IMDb Rating:
                  </Text>{' '}
                  {movie.details.imdbRating}
                </Text>
              )}

              {movie.details?.Plot && (
                <Box mt={2}>
                  <Text fontWeight="semibold" mb={1}>
                    Plot
                  </Text>
                  <Text color="gray.700">{movie.details.Plot}</Text>
                </Box>
              )}
            </Stack>
          </Box>
        </HStack>
      </Stack>
    </Container>
  )
}

export default MovieDetail
