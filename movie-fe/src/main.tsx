import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import './index.css'
import App from './App.tsx'

import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client'
import { setContext } from '@apollo/client/link/context'
import { ApolloProvider } from '@apollo/client/react'
import { Provider as ChakraProvider } from './components/ui/provider.tsx'
import { AppContextProvider } from './context/AppContext'
import { getAuthToken } from './helpers/session.ts'
import { Toaster } from './components/ui/toaster.tsx'

const httpLink = new HttpLink({
  uri: 'http://localhost:8000/graphql',
})

const authLink = setContext((_, { headers }) => {
  const token = getAuthToken()

  return {
    headers: {
      ...headers,
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
  }
})

const client = new ApolloClient({
  cache: new InMemoryCache(),
  link: authLink.concat(httpLink),
})

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <BrowserRouter>
      <ApolloProvider client={client}>
        <ChakraProvider forcedTheme="light">
          <AppContextProvider>
            <App />
            <Toaster />
          </AppContextProvider>
        </ChakraProvider>
      </ApolloProvider>
    </BrowserRouter>
  </StrictMode>
)
