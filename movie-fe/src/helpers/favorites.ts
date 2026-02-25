import { isAuthenticated } from './session'
import { addFavoriteRemote, removeFavoriteRemote } from '../api/favorites'

const LOCAL_FAVORITES_KEY = 'favoriteImdbIds'

function readLocalFavorites(): string[] {
  const raw = window.localStorage.getItem(LOCAL_FAVORITES_KEY)
  if (!raw) return []

  try {
    const parsed = JSON.parse(raw) as unknown
    if (Array.isArray(parsed)) {
      return parsed.filter((id): id is string => typeof id === 'string')
    }
    return []
  } catch {
    return []
  }
}

function writeLocalFavorites(ids: string[]): void {
  const uniqueIds = Array.from(new Set(ids))
  window.localStorage.setItem(LOCAL_FAVORITES_KEY, JSON.stringify(uniqueIds))
}

export function clearLocalFavorites(): void {
  writeLocalFavorites([])
}

export function isLocalFavorite(imdbId: string): boolean {
  if (!isAuthenticated()) {
    return readLocalFavorites().includes(imdbId)
  }

  return false
}

export function addLocalFavorite(imdbId: string): void {
  const current = readLocalFavorites()
  if (!current.includes(imdbId)) {
    writeLocalFavorites([...current, imdbId])
  }
}

export function removeLocalFavorite(imdbId: string): void {
  const current = readLocalFavorites()
  if (current.includes(imdbId)) {
    writeLocalFavorites(current.filter((id) => id !== imdbId))
  }
}

export async function toggleFavorite(
  imdbId: string,
  currentlyFavorite: boolean
): Promise<boolean> {
  const nextState = !currentlyFavorite

  if (isAuthenticated()) {
    try {
      if (nextState) {
        await addFavoriteRemote(imdbId)
      } else {
        await removeFavoriteRemote(imdbId)
      }
    } catch {
      return currentlyFavorite
    }
  } else {
    if (nextState) {
      addLocalFavorite(imdbId)
    } else {
      removeLocalFavorite(imdbId)
    }
  }

  return nextState
}

export async function syncFavoritesToBackend(): Promise<void> {
  if (!isAuthenticated()) return

  const local = readLocalFavorites()
  if (local.length === 0) return

  await Promise.all(
    local.map(async (imdbId) => {
      try {
        await addFavoriteRemote(imdbId)
      } catch {
        // Ignore individual errors to continue syncing the rest
      }
    })
  )

  clearLocalFavorites()
}
