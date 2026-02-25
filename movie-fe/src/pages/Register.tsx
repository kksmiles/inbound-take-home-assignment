import { useState } from 'react'
import { Link as RouterLink } from 'react-router-dom'
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
import { registerUser } from '../api/auth'

function Register() {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [passwordConfirmation, setPasswordConfirmation] = useState('')
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)
  const [success, setSuccess] = useState<string | null>(null)

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setError(null)
    setSuccess(null)

    if (password !== passwordConfirmation) {
      setError('Passwords do not match.')
      return
    }

    setLoading(true)

    try {
      await registerUser({
        name,
        email,
        password,
        password_confirmation: passwordConfirmation,
      })
      setSuccess('Registration successful. You can now log in.')
      setName('')
      setEmail('')
      setPassword('')
      setPasswordConfirmation('')
    } catch (err) {
      const message =
        err instanceof Error
          ? err.message
          : 'Failed to register. Please try again.'
      setError(message)
    } finally {
      setLoading(false)
    }
  }

  return (
    <Container maxW="35rem" py={16}>
      <Stack gap={8}>
        <Box textAlign="center">
          <Heading size="lg">Create an account</Heading>
          <Text color="gray.500" mt={2}>
            Register to start saving your favorite movies.
          </Text>
        </Box>

        <form onSubmit={handleSubmit}>
          <Fieldset.Root
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

              {success && (
                <Alert.Root status="success">
                  <Alert.Indicator />
                  <Alert.Content>
                    <Alert.Title>Success</Alert.Title>
                    <Alert.Description>{success}</Alert.Description>
                  </Alert.Content>
                </Alert.Root>
              )}

              <Field.Root>
                <Field.Label>Name</Field.Label>
                <Input
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  placeholder="Your name"
                  required
                />
              </Field.Root>

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
                  placeholder="At least 8 characters"
                  required
                />
              </Field.Root>

              <Field.Root>
                <Field.Label>Confirm Password</Field.Label>
                <Input
                  type="password"
                  value={passwordConfirmation}
                  onChange={(e) => setPasswordConfirmation(e.target.value)}
                  placeholder="Re-enter your password"
                  required
                />
              </Field.Root>

              <Button
                type="submit"
                colorScheme="blue"
                loading={loading}
                disabled={loading}
              >
                Register
              </Button>

              <Text fontSize="sm" color="gray.600">
                Already have an account?{' '}
                <Link asChild color="blue.500">
                  <RouterLink to="/login">Log in</RouterLink>
                </Link>
              </Text>
            </Stack>
          </Fieldset.Root>
        </form>
      </Stack>
    </Container>
  )
}

export default Register
