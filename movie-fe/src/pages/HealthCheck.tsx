import { useEffect, useState, useCallback } from 'react'
import {
  Box,
  Button,
  Container,
  Heading,
  HStack,
  Stack,
  Text,
  Code,
  Spinner,
  Icon,
} from '@chakra-ui/react'
import UserList from '../components/UserList'
import { FiCheckCircle, FiAlertTriangle, FiUser } from 'react-icons/fi'

function HealthCheck() {
  const [response, setResponse] = useState('')
  const [loading, setLoading] = useState(true)
  const [fetchTrigger, setFetchTrigger] = useState(0)

  const fetchHealthCheck = useCallback(() => {
    setLoading(true)
    fetch('http://localhost:8000/api/health_check')
      .then((res) => res.json())
      .then((data) => setResponse(JSON.stringify(data, null, 2)))
      .catch((error) => console.error('Error:', error))
      .finally(() => setLoading(false))
  }, [])

  useEffect(() => {
    const id = setTimeout(() => {
      fetchHealthCheck()
    }, 0)

    return () => clearTimeout(id)
  }, [fetchTrigger, fetchHealthCheck])

  const handleRetry = () => {
    setFetchTrigger((prev) => prev + 1)
  }

  return (
    <Container maxW="container.md" py={10}>
      <Stack>
        {/* Header */}
        <Box textAlign="center">
          <Heading size="lg">Backend Service Health Check</Heading>
          <Text color="gray.500" mt={2}>
            REST & GraphQL integration test
          </Text>
        </Box>

        {/* API Section */}
        <Box
          borderWidth="1px"
          borderRadius="lg"
          p={6}
          bg="gray.50"
          boxShadow="sm"
          divideX="5px"
        >
          <Heading size="md" mb={4}>
            Normal API Test
          </Heading>

          {loading ? (
            <HStack>
              <Spinner size="sm" />
              <Text>Checking backend status...</Text>
            </HStack>
          ) : (
            <Code
              display="block"
              whiteSpace="pre"
              p={4}
              borderRadius="md"
              width="100%"
            >
              {response}
            </Code>
          )}
        </Box>

        {/* GraphQL Section */}
        <Box borderWidth="1px" borderRadius="lg" p={6} boxShadow="sm">
          <Heading size="md" mb={4}>
            GraphQL Test
          </Heading>
          <UserList refreshKey={fetchTrigger} />
        </Box>

        {/* React Icons Section */}
        <Box borderWidth="1px" borderRadius="lg" p={6} boxShadow="sm">
          <Heading size="md" mb={4}>
            React Icons Test
          </Heading>

          <Stack gap={4}>
            <HStack>
              <Icon as={FiCheckCircle} color="green.500" boxSize={5} />
              <Text>Success state icon</Text>
            </HStack>

            <HStack>
              <Icon as={FiAlertTriangle} color="orange.400" boxSize={5} />
              <Text>Warning state icon</Text>
            </HStack>

            <HStack>
              <Icon as={FiUser} color="blue.500" boxSize={5} />
              <Text>User / profile icon</Text>
            </HStack>
          </Stack>
        </Box>

        {/* Actions */}
        <HStack justify="flex-end">
          <Button colorScheme="blue" onClick={handleRetry}>
            Retry
          </Button>
        </HStack>
      </Stack>
    </Container>
  )
}

export default HealthCheck
