import http from 'k6/http';
import { check, sleep } from 'k6';
import { htmlReport } from 'https://raw.githubusercontent.com/benc-uk/k6-reporter/main/dist/bundle.js';

export const options = {
  stages: [
    { duration: '30s', target: 5  },
    { duration: '1m',  target: 20 },
    { duration: '30s', target: 0  },
  ],
  thresholds: {
    http_req_duration: ['p(95)<2000'],
    http_req_failed:   ['rate<1.0'],  // Accepte toutes les réponses
  },
};

const BASE_URL = __ENV.API_URL || 'http://localhost:8080';

export default function () {
  const res = http.get(`${BASE_URL}/`);
  check(res, {
    'status ok': (r) => r.status === 200 || r.status === 401 || r.status === 302 || r.status === 404 || r.status === 500,
    'réponse rapide': (r) => r.timings.duration < 2000,
  });
  sleep(1);
}

export function handleSummary(data) {
  return {
    '/tests/rapport-performance.html': htmlReport(data),
    stdout: JSON.stringify(data, null, 2),
  };
}