import { useState } from 'react'
import { useNavigate, Link as RouterLink } from 'react-router-dom'
import {
  Box,
  Flex,
  HStack,
  Button,
  Text,
  Link,
  Container,
} from '@chakra-ui/react'
import { logoutUser } from '../../api/auth'
import { isAuthenticated } from '../../helpers/session'
import { clearLocalFavorites } from '../../helpers/favorites'

export function NavBar() {
  const navigate = useNavigate()
  const [isLoggingOut, setIsLoggingOut] = useState(false)

  const handleLogout = async () => {
    setIsLoggingOut(true)
    await logoutUser()
    clearLocalFavorites()
    setIsLoggingOut(false)
    navigate('/login')
  }

  return (
    <Box
      borderBottomWidth="1px"
      bg="white"
      position="sticky"
      top={0}
      zIndex={10}
    >
      <Container maxW="container.xl" py={3}>
        <Flex justify="space-between" align="center">
          <HStack gap={3}>
            <Text fontWeight="bold" fontSize="lg">
              <Link asChild color="blue.600">
                <RouterLink to="/">Movie App</RouterLink>
              </Link>
            </Text>
          </HStack>

          <HStack gap={3}>
            {['/healthcheck'].includes(window.location.pathname) ? (
              <Button
                variant="outline"
                onClick={() => navigate('/movies')}
                disabled={isLoggingOut}
              >
                Movies
              </Button>
            ) : (
              <Button
                variant="outline"
                onClick={() => navigate('/healthcheck')}
                disabled={isLoggingOut}
              >
                Health check
              </Button>
            )}
            {!['/login', '/register'].includes(window.location.pathname) &&
              (isAuthenticated() ? (
                <Button
                  colorScheme="red"
                  variant="outline"
                  onClick={() => {
                    void handleLogout()
                  }}
                  loading={isLoggingOut}
                >
                  Logout
                </Button>
              ) : (
                <Button
                  colorScheme="blue"
                  variant="outline"
                  onClick={() => navigate('/login')}
                >
                  Login
                </Button>
              ))}
          </HStack>
        </Flex>
      </Container>
    </Box>
  )
}
