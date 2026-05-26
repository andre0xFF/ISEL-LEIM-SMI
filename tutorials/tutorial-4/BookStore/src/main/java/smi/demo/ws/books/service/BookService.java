package smi.demo.ws.books.service;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import smi.demo.ws.books.beans.Book;

public class BookService {
    
    private static final Object lock = new Object();
    
    private static HashMap<String, Book> bookIdMap = null;
 
    public BookService() {
        super();
        
        synchronized ( BookService.lock) {
            if( bookIdMap==null ) {
                bookIdMap=new HashMap<>();

                Book b1;
                b1 = new Book();
                b1.setTitle("Java Web Services: Up and Running");
                b1.setIsbn("978-1449365110");
                b1.setPrice(29.73f);
                b1.setQuantity(33);
                bookIdMap.put(  b1.getIsbn(), b1 );

                Book b2;
                b2 = new Book();
                b2.setTitle("Java Web Services");
                b2.setIsbn("978-0596002695");
                b2.setPrice(36.30f);
                b2.setQuantity(21);
                bookIdMap.put(  b2.getIsbn(), b2 );

                Book b3;
                b3 = new Book();
                b3.setTitle("Java Web Services in a Nutshell");
                b3.setIsbn("978-0596003999");
                b3.setPrice(19.01f);
                b3.setQuantity(28);
                bookIdMap.put(  b3.getIsbn(), b3 );

                Book b4;
                b4 = new Book();
                b4.setTitle("RESTful Java Web Services - Third Edition");
                b4.setIsbn("978-1788294041");
                b4.setPrice(44.99f);
                b4.setQuantity(14);
                bookIdMap.put(  b4.getIsbn(), b4 );
            }                    
        }
    }

    public String getStoreName() {
        return "REST Book Store - SMI";
    }
    
    public Book getBookByISBN(String isbn) {
        for (Book currentBook : bookIdMap.values() ) {
            if (currentBook.getIsbn().equalsIgnoreCase(isbn)) {
                return currentBook;
            }
        }
        return new Book();
    }

    public Book getBookByTitle(String title) {
        for (Book currentBook : bookIdMap.values() ) {
            if (currentBook.getTitle().equalsIgnoreCase(title)) {
                return currentBook;
            }
        }
        return new Book();
    }

    public List<Book> getBooks() {
        List<Book> result;
        result = new ArrayList<>( bookIdMap.values() );

        return result;
    }
}
