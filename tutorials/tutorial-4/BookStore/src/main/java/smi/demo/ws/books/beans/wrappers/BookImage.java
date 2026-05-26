package smi.demo.ws.books.beans.wrappers;

import java.util.Base64;

public class BookImage {
  
  private final String bookImageCover;

  public String getImageCover() {
    return this.bookImageCover;
  }
  
  public BookImage(byte[] bookImageCover) {
    this.bookImageCover = (bookImageCover!=null) ? Base64.getEncoder().encodeToString( bookImageCover ) : "";
  }
  
  public BookImage(String bookImageCover) {
    this.bookImageCover = bookImageCover;
  }
}
