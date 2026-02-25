import type { AuthUser, LoginResponse } from '../api/auth'

const TOKEN_KEY = 'authToken'
const USER_KEY = 'authUser'

export interface AuthSession {
  token: string
  user: AuthUser
  expires_at?: string
}

export function setAuthSession(data: LoginResponse) {
  window.localStorage.setItem(TOKEN_KEY, data.token)
  window.localStorage.setItem(
    USER_KEY,
    JSON.stringify({
      id: data.user.id,
      name: data.user.name,
      email: data.user.email,
    })
  )
}

export function clearAuthSession() {
  window.localStorage.removeItem(TOKEN_KEY)
  window.localStorage.removeItem(USER_KEY)
}

export function getAuthToken(): string | null {
  return window.localStorage.getItem(TOKEN_KEY)
}

export function getAuthUser(): AuthUser | null {
  const raw = window.localStorage.getItem(USER_KEY)
  if (!raw) return null

  try {
    return JSON.parse(raw) as AuthUser
  } catch {
    return null
  }
}

export function isAuthenticated(): boolean {
  return Boolean(getAuthToken())
}
