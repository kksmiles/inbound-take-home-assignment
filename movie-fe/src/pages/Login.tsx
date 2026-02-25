import { useState } from 'react'
import { Link as RouterLink, useNavigate } from 'react-router-dom'
import {
  Box,
  Button,
  Container,
  Fieldset,
  Field,
  Heading,
  Input,
  Stack,
  Text,
  Alert,
  Link,
} from '@chakra-ui/react'
import { loginUser } from '../api/auth'
import { setAuthSession } from '../helpers/session'
import { syncFavoritesToBackend } from '../helpers/favorites'

function Login() {
  const navigate = useNavigate()
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setError(null)
    setLoading(true)

    try {
      const data = await loginUser({ email, password })
      setAuthSession(data)
      await syncFavoritesToBackend()
      navigate('/')
    } catch (err) {
      const message =
        err instanceof Error
          ? err.message
          : 'Failed to log in. Please try again.'
      setError(message)
    } finally {
      setLoading(false)
    }
  }

  return (
    <Container maxW="35rem" py={10}>
      <Stack gap={8}>
        <Box textAlign="center">
          <Heading size="lg">Log in</Heading>
          <Text color="gray.500" mt={2}>
            Access your account to manage favorites.
          </Text>
        </Box>

        <form onSubmit={handleSubmit}>
          <Fieldset.Root
            as="form"
            borderWidth="1px"
            borderRadius="lg"
            p={6}
            bg="white"
            boxShadow="sm"
          >
            <Stack gap={4}>
              {error && (
                <Alert.Root status="error">
                  <Alert.Indicator />
                  <Alert.Content>
                    <Alert.Title>Error</Alert.Title>
                    <Alert.Description>{error}</Alert.Description>
                  </Alert.Content>
                </Alert.Root>
              )}

              <Field.Root>
                <Field.Label>Email</Field.Label>
                <Input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="you@example.com"
                  required
                />
              </Field.Root>

              <Field.Root>
                <Field.Label>Password</Field.Label>
                <Input
                  type="password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Your password"
                  required
                />
              </Field.Root>

              <Button
                type="submit"
                colorScheme="blue"
                loading={loading}
                disabled={loading}
              >
                Log in
              </Button>

              <Text fontSize="sm" color="gray.600">
                Don&apos;t have an account yet?{' '}
                <Link asChild color="blue.500">
                  <RouterLink to="/register">Register</RouterLink>
                </Link>
              </Text>
            </Stack>
          </Fieldset.Root>
        </form>
      </Stack>
    </Container>
  )
}

export default Login
