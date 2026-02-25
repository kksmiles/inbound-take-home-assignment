import type { ChangeEvent } from 'react'
import { HStack, Input } from '@chakra-ui/react'

interface MovieSearchBarProps {
  value: string
  onChange: (value: string) => void
}

export function MovieSearchBar({ value, onChange }: MovieSearchBarProps) {
  const handleInputChange = (event: ChangeEvent<HTMLInputElement>) => {
    onChange(event.target.value)
  }

  return (
    <HStack gap={3}>
      <Input
        placeholder="Search movies by title..."
        value={value}
        onChange={handleInputChange}
        bg="white"
      />
    </HStack>
  )
}
