import { gql } from '@apollo/client'
import { useQuery } from '@apollo/client/react'
import {
  Box,
  Heading,
  Text,
  Stack,
  Spinner,
  Alert,
  HStack,
} from '@chakra-ui/react'
import { useEffect } from 'react'

const GET_USERS = gql`
  query GetUsers {
    users {
      paginatorInfo {
        currentPage
        total
      }
      data {
        id
        name
        email
      }
    }
  }
`

interface User {
  id: string
  name: string
  email: string
}

interface GetUsersResponse {
  users: {
    paginatorInfo: {
      currentPage: number
      total: number
    }
    data: User[]
  }
}

interface UserListProps {
  refreshKey: number
}

function UserList({ refreshKey }: UserListProps) {
  const { loading, error, data, refetch } = useQuery<GetUsersResponse>(
    GET_USERS,
    {}
  )

  useEffect(() => {
    refetch()
  }, [refreshKey, refetch])

  if (loading) {
    return (
      <Stack direction="row" align="center">
        <Spinner size="sm" />
        <Text>Loading users...</Text>
      </Stack>
    )
  }

  if (error) {
    console.error('Error fetching users:', error)
    return (
      <Alert.Root>
        <Alert.Indicator />
        <Alert.Content>
          <Alert.Title>Error</Alert.Title>
          <Alert.Description>{error.message}</Alert.Description>
        </Alert.Content>
      </Alert.Root>
    )
  }

  const users = data?.users.data ?? []
  const total = data?.users.paginatorInfo.total ?? 0

  return (
    <Box>
      <HStack mb={4} justify="space-between">
        <Heading size="sm">Users ({total})</Heading>
      </HStack>

      <Stack gap={3}>
        {users.map((user) => (
          <Box
            key={user.id}
            p={4}
            borderWidth="1px"
            borderRadius="md"
            _hover={{ bg: 'gray.50', color: 'blue.600' }}
          >
            <Text fontWeight="medium">{user.name}</Text>
            <Text fontSize="sm" color="gray.500">
              {user.email}
            </Text>
          </Box>
        ))}

        {users.length === 0 && <Text color="gray.500">No users found.</Text>}
      </Stack>
    </Box>
  )
}

export default UserList
