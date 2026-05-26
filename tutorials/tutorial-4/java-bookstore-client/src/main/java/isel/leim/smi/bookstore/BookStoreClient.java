package isel.leim.smi.bookstore;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import java.lang.reflect.Type;
import java.net.URI;
import java.net.URLEncoder;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.nio.charset.StandardCharsets;
import java.util.List;

/**
 * REST client for the BookStore API (Tutorial 4 — Task 2).
 * <p>
 * Server endpoints used:
 *   GET /books                        → List&lt;Book&gt; (all books)
 *   GET /books/book/by/title/{title}  → Book (single book details)
 *   GET /books/store/name             → {"storeName": "..."}
 * <p>
 * Run:  mvn compile exec:java
 * Override URL:  BOOKSTORE_URL=http://localhost:8082/.../rest/books mvn compile exec:java
 */
public class BookStoreClient {

    private static final String DEFAULT_URL =
        "http://java-bookstore-server:8080/ServiceBookStoreREST-Tomcat/rest/books";

    private static final Type BOOK_LIST_TYPE = new TypeToken<
        List<Book>
    >() {}.getType();

    private final String baseUrl;
    private final HttpClient httpClient;
    private final Gson gson;

    public BookStoreClient(String baseUrl) {
        this.baseUrl = baseUrl;
        this.httpClient = HttpClient.newHttpClient();
        this.gson = new Gson();
    }

    public void run() {
        System.out.println("BookStore REST Client");
        System.out.println("Base URL: " + baseUrl);
        System.out.println("=".repeat(60));

        // 1. List all books
        System.out.println("\n[1] GET /books — list all books\n");

        String listJson = get(baseUrl);
        if (listJson == null) return;

        List<Book> books = gson.fromJson(listJson, BOOK_LIST_TYPE);
        System.out.println("Found " + books.size() + " book(s):\n");

        for (Book book : books) {
            System.out.println("  " + book);
        }

        // 2. Get a single book by title (demonstrates the detail endpoint)
        if (!books.isEmpty()) {
            String title = books.get(0).getTitle();
            String encoded = URLEncoder.encode(title, StandardCharsets.UTF_8);
            String detailUrl = baseUrl + "/book/by/title/" + encoded;

            System.out.println(
                "\n[2] GET /books/book/by/title/" + title + "\n"
            );

            String detailJson = get(detailUrl);
            if (detailJson != null) {
                Book detail = gson.fromJson(detailJson, Book.class);
                System.out.println("  Title    : " + detail.getTitle());
                System.out.println("  ISBN     : " + detail.getIsbn());
                System.out.printf("  Price    : %.2f%n", detail.getPrice());
                System.out.println("  Quantity : " + detail.getQuantity());
            }
        }

        System.out.println("\n" + "=".repeat(60));
        System.out.println("Done.");
    }

    /**
     * Performs a GET request and returns the response body, or null on error.
     */
    private String get(String url) {
        try {
            HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .header("Accept", "application/json")
                .GET()
                .build();

            HttpResponse<String> response = httpClient.send(
                request,
                HttpResponse.BodyHandlers.ofString()
            );

            if (response.statusCode() / 100 != 2) {
                System.err.println(
                    "Error: HTTP " + response.statusCode() + " for " + url
                );
                return null;
            }
            return response.body();
        } catch (java.net.ConnectException e) {
            System.err.println(
                "Error: connection refused — is the BookStore server running?"
            );
            System.err.println("       Tried: " + url);
            return null;
        } catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
            return null;
        }
    }

    public static void main(String[] args) {
        String url = System.getenv("BOOKSTORE_URL");
        if (url == null || url.isBlank()) {
            url = DEFAULT_URL;
        }
        new BookStoreClient(url).run();
    }
}
