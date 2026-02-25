import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import './index.css'
import App from './App.tsx'

import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client'
import { ApolloProvider } from '@apollo/client/react'
import { Provider as ChakraProvider } from './components/ui/provider.tsx'
import { AppContextProvider } from './context/AppContext'

const client = new ApolloClient({
  cache: new InMemoryCache(),
  link: new HttpLink({
    uri: 'http://localhost:8000/graphql',
  }),
})

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <BrowserRouter>
      <ApolloProvider client={client}>
        <ChakraProvider forcedTheme="light">
          <AppContextProvider>
            <App />
          </AppContextProvider>
        </ChakraProvider>
      </ApolloProvider>
    </BrowserRouter>
  </StrictMode>
)
