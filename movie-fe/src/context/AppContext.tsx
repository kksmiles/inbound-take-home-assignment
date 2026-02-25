import React, { createContext, type ReactNode } from 'react'

interface AppContextType {
  appName: string
}

const AppContext = createContext<AppContextType | undefined>(undefined)

interface AppContextProviderProps {
  children: ReactNode
}

export const AppContextProvider: React.FC<AppContextProviderProps> = ({
  children,
}) => {
  const appName = 'My Awesome App'

  const contextValue: AppContextType = {
    appName,
  }

  return (
    <AppContext.Provider value={contextValue}>{children}</AppContext.Provider>
  )
}
