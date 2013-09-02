package testbed.compiler;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;

import testbed.languages.Java;
import testbed.languages.Languages;



public class RequestThread extends Thread{
	Socket s; // socket connection
	int n; // request number
	File dir; // staging directory
	
	public RequestThread(Socket s, int n) {
		this.s=s;
		this.n=n;
		dir = new File("stage/" + n);
	}
	
	public void run() {
		
		dir.mkdirs(); // create staging directory
		
		try {
			BufferedReader in = new BufferedReader(new InputStreamReader(s.getInputStream()));
			PrintWriter out = new PrintWriter(s.getOutputStream(), true);
			// read input from the PHP script
			String file = in.readLine();
			int timeout = Integer.parseInt(in.readLine());
			String contents = in.readLine().replace("$_n_$", "\n");
			String input = in.readLine().replace("$_n_$", "\n");
			String lang = in.readLine();
			System.out.println("Compiling " + file + "...");
			// create the sample input file
			PrintWriter writer = new PrintWriter(new FileOutputStream("stage/" + n +"/in.txt"));
			writer.println(input);
			writer.close();
			Languages l = null;
			// create the language specific compiler
			if(lang.equals("java"))
				l = new Java(file, timeout, contents, dir.getAbsolutePath());
			l.compile(); // compile the file
			String errors = compileErrors();
			if(!errors.equals("")) { // check for compilation errors
				out.println("0");
				out.println(errors);
			} else {
				// execute the program and return output
				l.execute();
				if(l.timedout)
					out.println("2");
				else {
					out.println("1");
					out.println(execMsg());
				}
			}
			s.close();
		} catch (IOException e) {
			e.printStackTrace();
		}

	}
	
	
	public String compileErrors() {
		String line = "";
		StringBuilder content = new StringBuilder();
		try {
			BufferedReader fin = new BufferedReader(new InputStreamReader(new FileInputStream(dir.getAbsolutePath() + "/err.txt")));
			while((line = fin.readLine()) != null)
				content.append(line + "\n");
			fin.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return content.toString().trim();
	}
	
	// method to return the execution output
	public String execMsg() {
		String line = "";
		StringBuilder content = new StringBuilder();
		try {
			BufferedReader fin = new BufferedReader(new InputStreamReader(new FileInputStream(dir.getAbsolutePath() + "/out.txt")));
			while((line = fin.readLine()) != null)
				content.append(line + "\n");
			fin.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return content.toString().trim();
	}


}
