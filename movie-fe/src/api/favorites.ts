import { apiFetch, handleJsonResponse } from './client'

export async function addFavoriteRemote(imdbId: string): Promise<void> {
  const res = await apiFetch('/favorites', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ imdb_id: imdbId }),
  })

  await handleJsonResponse<unknown>(res)
}

export async function removeFavoriteRemote(imdbId: string): Promise<void> {
  const res = await apiFetch(`/favorites/${encodeURIComponent(imdbId)}`, {
    method: 'DELETE',
  })

  await handleJsonResponse<unknown>(res)
}
