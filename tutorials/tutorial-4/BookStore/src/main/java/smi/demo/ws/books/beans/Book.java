package smi.demo.ws.books.beans;

public class Book {
    private String isbn;
    private String title;
    private int quantity;
    private float price;

    public Book() {
        this.isbn = "isbn";
        this.title = "title";
        this.quantity = 1;
        this.price = 1.0f;
    }
    
    public Book(String isbn, String title, int quantity, float price) {
        this.isbn = isbn;
        this.title = title;
        this.quantity = quantity;
        this.price = price;
    }

    @Override
    public String toString() {
        return String.format("{%s, %s, %d, %f}", this.getIsbn(), this.getTitle(), this.getQuantity(), this.getPrice());
    }

    public String getIsbn() {
        return isbn;
    }
    
    public float getPrice() {
        return price;
    }
    
    public int getQuantity() {
        return quantity;
    }

    public String getTitle() {
        return title;
    }

    public void setIsbn(String isbn) {
        this.isbn = isbn;
    }

    public void setPrice(float price) {
        this.price = price;
    }    
    
    public void setQuantity(int quantity) {
        this.quantity = quantity;
    }
    
    public void setTitle(String title) {
        this.title = title;
    }
}
