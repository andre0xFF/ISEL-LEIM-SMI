package isel.leim.smi.restserver;

import org.glassfish.jersey.jsonb.JsonBindingFeature;
import org.glassfish.jersey.server.ResourceConfig;

public class RestServerConfig extends ResourceConfig {

    public RestServerConfig() {
        packages("isel.leim.smi.restserver");
        register(JsonBindingFeature.class);
        register(CorsFilter.class);
    }
}
