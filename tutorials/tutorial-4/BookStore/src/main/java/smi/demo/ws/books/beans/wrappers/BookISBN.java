package smi.demo.ws.books.beans.wrappers;

public class BookISBN {
  
  private final String bookIsbn;

  public String getBookIsbn() {
    return this.bookIsbn;
  }
  
  public BookISBN(String bookIsbn) {
    this.bookIsbn = bookIsbn;
  }
  
}
