package smi.client;

import com.dataaccess.numberconversion.NumberConversion;
import com.dataaccess.numberconversion.NumberConversionSoapType;
import java.math.BigDecimal;
import java.math.BigInteger;

public class Main {

    public static void main(String[] args) {
        System.out.println("NumberConversion SOAP Client (JAX-WS/CXF)");
        System.out.println();

        try {
            // Create the service and obtain the SOAP port
            NumberConversion service = new NumberConversion();
            NumberConversionSoapType port = service.getNumberConversionSoap();

            // NumberToDollars
            BigDecimal amount = new BigDecimal("15.99");
            System.out.println("Calling NumberToDollars(" + amount + ")...");
            String dollars = port.numberToDollars(amount);
            System.out.println("Result: " + dollars);
            System.out.println();

            // NumberToWords
            BigInteger number = BigInteger.valueOf(12344);
            System.out.println("Calling NumberToWords(" + number + ")...");
            String words = port.numberToWords(number);
            System.out.println("Result: " + words);
            System.out.println();

            System.out.println("Done!");
        } catch (Exception e) {
            System.err.println(
                "Error calling NumberConversion service: " + e.getMessage()
            );
            e.printStackTrace();
        }
    }
}
