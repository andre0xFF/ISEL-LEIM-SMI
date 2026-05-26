# /// script
# requires-python = ">=3.12"
# dependencies = ["httpx>=0.27"]
# ///
"""
Python REST Client — Tutorial 4, Task 3
Consumes the Java JAX-RS server running at http://java-rest-server:8083
Endpoints:
  GET /api/datetime          → {"dateTime": "..."}
  GET /api/toupper?text=...  → {"original": "...", "result": "..."}
"""

import os
import sys

import httpx

BASE_URL = os.getenv("REST_SERVER_URL", "http://java-rest-server:8083")


def get_datetime(client: httpx.Client) -> None:
    print("── GET /api/datetime ──")
    resp = client.get(f"{BASE_URL}/api/datetime")
    resp.raise_for_status()
    data = resp.json()
    print(f"  Server date/time: {data['dateTime']}")
    print()


def to_upper(client: httpx.Client, text: str) -> None:
    print(f'── GET /api/toupper?text="{text}" ──')
    resp = client.get(f"{BASE_URL}/api/toupper", params={"text": text})
    resp.raise_for_status()
    data = resp.json()
    print(f"  Original: {data['original']}")
    print(f"  Result  : {data['result']}")
    print()


def main() -> None:
    print(f"Python REST Client — server at {BASE_URL}\n")

    try:
        with httpx.Client(timeout=10) as client:
            get_datetime(client)
            to_upper(client, "hello world")
            to_upper(client, "sistemas multimédia para a internet")
    except httpx.ConnectError:
        print(
            f"ERROR: Could not connect to {BASE_URL}.\n"
            "Make sure the Java REST server is running:\n"
            "  docker compose --profile server up java-rest-server",
            file=sys.stderr,
        )
        sys.exit(1)


if __name__ == "__main__":
    main()
