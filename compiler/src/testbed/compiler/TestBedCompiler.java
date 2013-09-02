/**
 * 
 */
package testbed.compiler;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;



/**
 * @author sushant
 *
 */
public class TestBedCompiler {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		int n=0;
		try {
			ServerSocket server=new ServerSocket(3429);
			System.out.println("Test Bed compilation server running ...");
			while(true) {
				n++;
				// accept any incoming connection and process it on a new thread
				Socket s = server.accept();
				RequestThread request = new RequestThread(s, n);
				request.start();
			}
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}

}
