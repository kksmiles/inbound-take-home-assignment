import { clearAuthSession } from '../helpers/session'
import { apiFetch, handleJsonResponse } from './client'

export interface AuthUser {
  id: string | number
  name: string
  email: string
}

export interface LoginResponse {
  user: AuthUser
  token: string
  expires_at: string
}

export interface MeResponse {
  user: AuthUser
}

export async function registerUser(payload: {
  name: string
  email: string
  password: string
  password_confirmation: string
}) {
  const res = await apiFetch('/auth/register', {
    method: 'POST',
    withAuth: false,
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload),
  })

  await handleJsonResponse<unknown>(res)
}

export async function loginUser(payload: {
  email: string
  password: string
}): Promise<LoginResponse> {
  const res = await apiFetch('/auth/login', {
    method: 'POST',
    withAuth: false,
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload),
  })

  const json = await handleJsonResponse<{ data: LoginResponse }>(res)
  return json.data
}

export async function logoutUser(): Promise<void> {
  try {
    const res = await apiFetch('/auth/logout', {
      method: 'POST',
    })

    await handleJsonResponse<unknown>(res)
  } catch {
    clearAuthSession()
  } finally {
    clearAuthSession()
  }
}

export async function fetchCurrentUser(): Promise<AuthUser> {
  const res = await apiFetch('/auth/me', {
    method: 'GET',
  })

  const json = await handleJsonResponse<{ data: MeResponse }>(res)
  return json.data.user
}
