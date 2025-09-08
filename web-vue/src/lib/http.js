import axios from 'axios'

// Prefer explicit API base URL from env during development to avoid proxy mismatches
// Falls back to '/api' which works when served behind the same origin with a reverse proxy
const baseURL = import.meta?.env?.VITE_API_BASE_URL || '/api'

export const http = axios.create({
  baseURL,
  withCredentials: true,
  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',
  headers: {
    Accept: 'application/json'
  }
})

http.interceptors.response.use(
  (res) => res,
  (error) => {
    // eslint-disable-next-line no-console
    console.error('HTTP error:', error)
    return Promise.reject(error)
  }
)


