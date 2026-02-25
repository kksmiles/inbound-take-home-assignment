import { useEffect, useState } from 'react'
import { IconButton } from '@chakra-ui/react'
import { FiHeart } from 'react-icons/fi'
import { isLocalFavorite, toggleFavorite } from '../../helpers/favorites'
import { isAuthenticated } from '../../helpers/session'

interface FavoriteButtonProps {
  imdbId: string
  size?: 'sm' | 'md' | 'lg'
  initialIsFavorited?: boolean
}

export function FavoriteButton({
  imdbId,
  size = 'sm',
  initialIsFavorited,
}: FavoriteButtonProps) {
  const [favorite, setFavorite] = useState<boolean>(() => {
    if (typeof initialIsFavorited === 'boolean' && isAuthenticated()) {
      return initialIsFavorited
    }

    return isLocalFavorite(imdbId)
  })
  const [loading, setLoading] = useState(false)

  useEffect(() => {
    if (typeof initialIsFavorited === 'boolean' && isAuthenticated()) {
      setFavorite(initialIsFavorited)
      return
    }

    setFavorite(isLocalFavorite(imdbId))
  }, [imdbId, initialIsFavorited])

  const handleClick: React.MouseEventHandler<HTMLButtonElement> = async (
    event
  ) => {
    event.preventDefault()
    event.stopPropagation()

    setLoading(true)
    try {
      const next = await toggleFavorite(imdbId, favorite)
      setFavorite(next)
    } finally {
      setLoading(false)
    }
  }

  return (
    <IconButton
      aria-label={favorite ? 'Remove from favorites' : 'Add to favorites'}
      size={size}
      variant={favorite ? 'solid' : 'outline'}
      colorScheme={favorite ? 'red' : 'gray'}
      onClick={handleClick}
      loading={loading}
    >
      <FiHeart />
    </IconButton>
  )
}
