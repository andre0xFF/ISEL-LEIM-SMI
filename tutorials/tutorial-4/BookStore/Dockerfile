# Stage 1: Build
FROM maven:3.9-eclipse-temurin-17 AS build
WORKDIR /build
COPY pom.xml .
RUN mvn dependency:go-offline -q
COPY src src
RUN mvn package -q -DskipTests

# Stage 2: Runtime
FROM tomcat:9.0-jdk17
RUN rm -rf /usr/local/tomcat/webapps/*
COPY --from=build /build/target/ServiceBookStoreREST-Tomcat.war /usr/local/tomcat/webapps/ServiceBookStoreREST-Tomcat.war
EXPOSE 8080
CMD ["catalina.sh", "run"]
