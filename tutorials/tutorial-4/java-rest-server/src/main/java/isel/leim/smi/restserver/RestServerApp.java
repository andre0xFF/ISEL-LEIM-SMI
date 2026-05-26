package isel.leim.smi.restserver;

import java.net.URI;
import org.glassfish.grizzly.http.server.HttpServer;
import org.glassfish.jersey.grizzly2.httpserver.GrizzlyHttpServerFactory;
import org.glassfish.jersey.server.ResourceConfig;

/**
 * Main entry point — starts a Grizzly HTTP server with JAX-RS resources.
 * <p>
 * Binds to 0.0.0.0:8083 so the service is reachable from other Docker containers.
 */
public class RestServerApp {

    private static final int PORT = 8083;

    public static void main(String[] args) throws Exception {
        String endpoint = String.format("http://0.0.0.0:%d/api", PORT);

        ResourceConfig config = new RestServerConfig();
        HttpServer server = GrizzlyHttpServerFactory.createHttpServer(
            URI.create(endpoint),
            config
        );

        Runtime.getRuntime().addShutdownHook(new Thread(server::shutdownNow));

        System.out.printf(
            "REST server started at http://localhost:%d/api%n",
            PORT
        );
        System.out.println("Endpoints:");
        System.out.printf("  GET http://localhost:%d/api/datetime%n", PORT);
        System.out.printf(
            "  GET http://localhost:%d/api/toupper?text=...%n",
            PORT
        );
        System.out.println();

        // Block until the JVM is terminated (e.g. Ctrl+C or docker stop)
        Thread.currentThread().join();
    }
}
