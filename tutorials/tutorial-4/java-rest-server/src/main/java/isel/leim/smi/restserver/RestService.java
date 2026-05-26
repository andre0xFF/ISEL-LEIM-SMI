package isel.leim.smi.restserver;

import jakarta.ws.rs.GET;
import jakarta.ws.rs.Path;
import jakarta.ws.rs.Produces;
import jakarta.ws.rs.QueryParam;
import jakarta.ws.rs.core.MediaType;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

@Path("/")
public class RestService {

    public static class DateTimeResponse {
        public String dateTime;

        public DateTimeResponse() {}

        public DateTimeResponse(String dateTime) {
            this.dateTime = dateTime;
        }
    }

    public static class ToUpperResponse {
        public String original;
        public String result;

        public ToUpperResponse() {}

        public ToUpperResponse(String original, String result) {
            this.original = original;
            this.result = result;
        }
    }

    @GET
    @Path("/datetime")
    @Produces(MediaType.APPLICATION_JSON)
    public DateTimeResponse getServerDateTime() {
        String now = LocalDateTime.now().format(DateTimeFormatter.ISO_LOCAL_DATE_TIME);
        return new DateTimeResponse(now);
    }

    @GET
    @Path("/toupper")
    @Produces(MediaType.APPLICATION_JSON)
    public ToUpperResponse toUpper(@QueryParam("text") String text) {
        if (text == null) {
            text = "";
        }
        return new ToUpperResponse(text, text.toUpperCase());
    }
}
