import { clearAuthSession, getAuthToken } from '../helpers/session'
import { toaster } from '../components/ui/toasterInstance'

export const API_BASE_URL = 'http://localhost:8000/api'

interface ApiFetchOptions extends RequestInit {
  withAuth?: boolean
}

export async function apiFetch(
  pathOrUrl: string,
  options: ApiFetchOptions = {}
): Promise<Response> {
  const { withAuth = true, headers, ...rest } = options

  const token = withAuth ? getAuthToken() : null

  const baseHeaders: HeadersInit = {
    Accept: 'application/json',
  }

  const finalHeaders: HeadersInit = {
    ...baseHeaders,
    ...(headers as HeadersInit | undefined),
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
  }

  const isAbsolute = /^https?:\/\//.test(pathOrUrl)
  const url = isAbsolute ? pathOrUrl : `${API_BASE_URL}${pathOrUrl}`

  try {
    return await fetch(url, {
      ...rest,
      headers: finalHeaders,
    })
  } catch (error) {
    const message =
      error instanceof Error ? error.message : 'Network request failed'

    if (typeof window !== 'undefined') {
      toaster.create({
        type: 'error',
        title: 'Something went wrong',
        description: message,
      })
    }

    throw error
  }
}

export async function handleJsonResponse<T>(response: Response): Promise<T> {
  const json = (await response.json().catch(() => ({}))) as unknown

  if (!response.ok) {
    if (response.status === 401) {
      clearAuthSession()
      if (
        typeof window !== 'undefined' &&
        window.location.pathname !== '/login'
      ) {
        window.location.href = '/login'
      }
    }

    const messageFromErrors =
      (json as Record<string, unknown>)?.message ??
      ((json as Record<string, unknown>)?.errors
        ? Object.values(
            (json as Record<string, unknown>).errors as Record<string, string[]>
          )
            .flat()
            .join(' ')
        : null)

    const message =
      (messageFromErrors as string | null) ||
      `Request failed with status ${response.status}`

    if (typeof window !== 'undefined') {
      toaster.create({
        type: 'error',
        title: 'Request failed',
        description: message,
      })
    }

    throw new Error(message)
  }

  return json as T
}
