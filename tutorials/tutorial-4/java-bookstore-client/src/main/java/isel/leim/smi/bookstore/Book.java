package isel.leim.smi.bookstore;

/**
 * Simple POJO representing a book from the BookStore API.
 */
public class Book {

    private String title;
    private String isbn;
    private float price;
    private int quantity;

    public String getTitle() {
        return title;
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

    @Override
    public String toString() {
        return String.format(
            "%s | ISBN: %s | Price: %.2f | Qty: %d",
            title,
            isbn,
            price,
            quantity
        );
    }
}
