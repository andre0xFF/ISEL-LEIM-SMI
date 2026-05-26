package smi.demo.ws.books.controller;

import java.util.List;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

import smi.demo.ws.books.service.BookService;
import smi.demo.ws.books.beans.Book;
import smi.demo.ws.books.beans.wrappers.BookISBN;
import smi.demo.ws.books.beans.wrappers.BookPrice;
import smi.demo.ws.books.beans.wrappers.BookQuantity;
import smi.demo.ws.books.beans.wrappers.StoreName;

@Path("/books")
public class BookController {

    private final BookService bookService = new BookService();
    
    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public List<Book> getBooks() {
        return this.bookService.getBooks();
    }

    @GET
    @Path("/store/name")
    @Produces(MediaType.APPLICATION_JSON)
    public StoreName getStoreName() {
        return new StoreName( this.bookService.getStoreName() );
    }
    
    @GET
    @Path("/book/by/isbn/{isbn}")
    @Produces(MediaType.APPLICATION_JSON)
    public Book getBookByISBN(@PathParam("isbn") String isbn) {
        return this.bookService.getBookByISBN(isbn);
    }

    @GET
    @Path("/book/by/title/{title}")
    @Produces(MediaType.APPLICATION_JSON)
    public Book getBookByTitle(@PathParam("title") String title) {
        return this.bookService.getBookByTitle(title);
    }  

    @GET
    @Path("/book/isbn/{title}")
    @Produces(MediaType.APPLICATION_JSON)
    public BookISBN getBookISBN(@PathParam("title") String title) {
        return new BookISBN( this.bookService.getBookByTitle(title).getIsbn() );
    }
    
    @GET
    @Path("/book/price/{isbn}")
    @Produces(MediaType.APPLICATION_JSON)
    public BookPrice getBookPrice(@PathParam("isbn") String isbn) {
        return new BookPrice( this.bookService.getBookByISBN(isbn).getPrice() );
    }
    
    @GET
    @Path("/book/quantity/{isbn}")
    @Produces(MediaType.APPLICATION_JSON)
    public BookQuantity getBookQuantity(@PathParam("isbn") String isbn) {
        return new BookQuantity( this.bookService.getBookByISBN(isbn).getQuantity() );
    }
}
