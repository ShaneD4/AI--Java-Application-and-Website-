//Taken from various sources, including: http://labe.felk.cvut.cz/~xfaigl/mep/xml/java-xml.htm and scottjohnturner

//Amended by Shane Donnelly 15400372

import java.net.*;
import java.util.ArrayList;
import java.io.*;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerConfigurationException;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Text;

public class urlreader {
    private static ArrayList<String> name=new ArrayList<String>();
    private static ArrayList<String> job=new ArrayList<String>();
    private static ArrayList<String> email=new ArrayList<String>();
    private static ArrayList<String> postcode=new ArrayList<String>();
    private static ArrayList<String> telephone=new ArrayList<String>();
    private static ArrayList<String> birthDate=new ArrayList<String>();
    private static ArrayList<String> medicalCode=new ArrayList<String>();
    private static ArrayList<String> codingSystem=new ArrayList<String>();
    private static ArrayList<String> eventName=new ArrayList<String>();
    private static ArrayList<String> startDate=new ArrayList<String>();
    private static ArrayList<String> eventPostcode=new ArrayList<String>();
    private static ArrayList<String> doorTime=new ArrayList<String>();
    private static ArrayList<String> duration=new ArrayList<String>();
    private static ArrayList<String> about=new ArrayList<String>();
    private static ArrayList<String> remainingAttendeeCapacity=new ArrayList<String>();
    private static ArrayList<String> maximumAttendeeCapacity=new ArrayList<String>();
    public static void main(String[] args) throws Exception {
        URL[] item=new URL[3];
        item[0] = new URL("http://myorchid.me/ai/microdata_users.php");
        item[1] = new URL("http://myorchid.me/ai/microdata_users2.php");
        item[2] = new URL("http://myorchid.me/ai/microdata_events.php");
        DocumentBuilderFactory dbfac = DocumentBuilderFactory.newInstance();
        DocumentBuilder docBuilder = dbfac.newDocumentBuilder();
        Document doc = docBuilder.newDocument();

        for(int loop1=0;loop1<2;loop1++) {
            BufferedReader in = new BufferedReader(
                    new InputStreamReader(
                            item[loop1].openStream()));
            String inputLine;
            while ((inputLine = in.readLine()) != null)//reads in the html page line by line
            {
                String inputLine11 = inputLine.replaceAll("\"", "");//removes speechmarks from text
                String inputLine21 = inputLine11.replaceAll("<strong>", "");
                String inputLine2 = inputLine21.replaceAll("</strong>", "");
                String[] parts = inputLine2.split("<span itemprop=");//splits into sections based on it is after <span class="


                for (int loop = 0; loop < parts.length; loop++) {

                    if (parts[loop].contains("name>")) {
                        name.add(parts[loop].substring(5, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("jobTitle>")) {
                        job.add(parts[loop].substring(9, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("email>")) {
                        email.add(parts[loop].substring(6, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("postalCode>")) {
                        postcode.add(parts[loop].substring(11, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("telephone>")) {
                        telephone.add(parts[loop].substring(10, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("birthDate>")) {
                        birthDate.add(parts[loop].substring(10, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("code>")) {
                        medicalCode.add(parts[loop].substring(5, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("codingSystem>")) {
                        codingSystem.add(parts[loop].substring(13, (parts[loop].length()) - 7));
                    }
                }
            }
            in.close();
        }


            BufferedReader in2 = new BufferedReader(
                    new InputStreamReader(
                            item[2].openStream()));
            String inputLine4;
            while ((inputLine4 = in2.readLine()) != null)//reads in the html page line by line
            {
                String inputLine11=inputLine4.replaceAll("\"", "");//removes speechmarks from text
                String inputLine21=inputLine11.replaceAll("<strong>", "");
                String inputLine2=inputLine21.replaceAll("</strong>", "");
                String[] parts = inputLine2.split("<span itemprop=");//splits into sections based on it is after <span class="


                for (int loop = 0; loop < parts.length; loop++) {

                    if (parts[loop].contains("name>")) {
                        eventName.add(parts[loop].substring(5, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("startDate>")) {
                        startDate.add(parts[loop].substring(10, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("postalCode>")) {
                        eventPostcode.add(parts[loop].substring(11, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("doorTime>")) {
                        doorTime.add(parts[loop].substring(9, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("duration>")) {
                        duration.add(parts[loop].substring(9, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("about>")) {
                        about.add(parts[loop].substring(6, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("remainingAttendeeCapacity>")) {
                        remainingAttendeeCapacity.add(parts[loop].substring(26, (parts[loop].length()) - 7));
                    }
                    if (parts[loop].contains("maximumAttendeeCapacity>")) {
                        maximumAttendeeCapacity.add(parts[loop].substring(24, (parts[loop].length()) - 7));
                    }

                }

            }in2.close();


        try {
            /////////////////////////////
            //Creating an empty XML Document
            //Creating the XML tree

            Element root = doc.createElement("data");
            doc.appendChild(root);


            //User data

            for (int loopx=0;loopx<10;loopx++)
            {
                Element user=doc.createElement("user");
                root.appendChild(user);

                Element first1 = doc.createElement("name");
                user.appendChild(first1);
                //add a text element to the child
                Text text = doc.createTextNode(name.get(loopx*5));
                first1.appendChild(text);


                Element first2 = doc.createElement("job_title");
                user.appendChild(first2);
                //add a text element to the child
                Text text2 = doc.createTextNode(job.get(loopx));
                first2.appendChild(text2);

                Element first3 = doc.createElement("email");
                user.appendChild(first3);
                //add a text element to the child
                Text text3 = doc.createTextNode(email.get(loopx));
                first3.appendChild(text3);

                Element first4 = doc.createElement("postcode");
                user.appendChild(first4);
                //add a text element to the child
                Text text4 = doc.createTextNode(postcode.get(loopx));
                first4.appendChild(text4);

                Element first5 = doc.createElement("telephone");
                user.appendChild(first5);
                //add a text element to the child
                Text text5 = doc.createTextNode(telephone.get(loopx));
                first5.appendChild(text5);

                Element first6 = doc.createElement("birthDate");
                user.appendChild(first6);
                //add a text element to the child
                Text text6 = doc.createTextNode(birthDate.get(loopx));
                first6.appendChild(text6);

                Element first7 = doc.createElement("code");
                user.appendChild(first7);
                //add a text element to the child
                Text text7 = doc.createTextNode(medicalCode.get(loopx));
                first7.appendChild(text7);

                Element first8 = doc.createElement("codingSystem");
                user.appendChild(first8);
                //add a text element to the child
                Text text8 = doc.createTextNode(codingSystem.get(loopx));
                first8.appendChild(text8);

                Element first9 = doc.createElement("medicalCondition");
                user.appendChild(first9);
                //add a text element to the child
                Text text9 = doc.createTextNode(name.get(loopx*5+1));
                first9.appendChild(text9);

                Element first10 = doc.createElement("associatedAnatomy");
                user.appendChild(first10);
                //add a text element to the child
                Text text10 = doc.createTextNode(name.get(loopx*5+2));
                first10.appendChild(text10);

                Element first11 = doc.createElement("cause");
                user.appendChild(first11);
                //add a text element to the child
                Text text11 = doc.createTextNode(name.get(loopx*5+3));
                first11.appendChild(text11);

                Element first12 = doc.createElement("currentTreatment");
                user.appendChild(first12);
                //add a text element to the child
                Text text12 = doc.createTextNode(name.get(loopx*5+4));
                first12.appendChild(text12);

            }


            // Event data
            for (int loopx=0;loopx<3;loopx++)
            {
                Element event=doc.createElement("event");
                root.appendChild(event);

                Element first13 = doc.createElement("name");
                event.appendChild(first13);
                //add a text element to the child
                Text text13 = doc.createTextNode(eventName.get(loopx));
                first13.appendChild(text13);


                Element first14 = doc.createElement("startDate");
                event.appendChild(first14);
                //add a text element to the child
                Text text14 = doc.createTextNode(startDate.get(loopx));
                first14.appendChild(text14);

                Element first15 = doc.createElement("postalCode");
                event.appendChild(first15);
                //add a text element to the child
                Text text15 = doc.createTextNode(eventPostcode.get(loopx));
                first15.appendChild(text15);

                Element first16 = doc.createElement("doorTime");
                event.appendChild(first16);
                //add a text element to the child
                Text text16 = doc.createTextNode(doorTime.get(loopx));
                first16.appendChild(text16);

                Element first17 = doc.createElement("duration");
                event.appendChild(first17);
                //add a text element to the child
                Text text17 = doc.createTextNode(duration.get(loopx));
                first17.appendChild(text17);

                Element first18 = doc.createElement("about");
                event.appendChild(first18);
                //add a text element to the child
                Text text18 = doc.createTextNode(about.get(loopx));
                first18.appendChild(text18);

                Element first19 = doc.createElement("remainingAttendeeCapacity");
                event.appendChild(first19);
                //add a text element to the child
                Text text19 = doc.createTextNode(remainingAttendeeCapacity.get(loopx));
                first19.appendChild(text19);

                Element first20 = doc.createElement("maximumAttendeeCapacity");
                event.appendChild(first20);
                //add a text element to the child
                Text text20 = doc.createTextNode(maximumAttendeeCapacity.get(loopx));
                first20.appendChild(text20);


                //Output the XML
            }


            //set up a transformer
            TransformerFactory transfac = TransformerFactory.newInstance();
            Transformer trans = transfac.newTransformer();
            trans.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "yes");
            trans.setOutputProperty(OutputKeys.INDENT, "yes");

            //create string from xml tree
            StringWriter sw = new StringWriter();
            StreamResult result = new StreamResult(sw);
            DOMSource source = new DOMSource(doc);
            trans.transform(source, result);
            String xmlString = sw.toString();

            //print xml
            System.out.println("Here's the xml:\n\n" + xmlString);

        } catch (Exception e) {
            System.out.println(e);

        }
        saveXMLDocument("example2.xml", doc);
    }
    public static boolean saveXMLDocument(String fileName, Document doc) {
        System.out.println("Saving XML file... " + fileName);
        // open output stream where XML Document will be saved
        File xmlOutputFile = new File(fileName);
        FileOutputStream fos;
        Transformer transformer;
        try {
            fos = new FileOutputStream(xmlOutputFile);
        }
        catch (FileNotFoundException e) {
            System.out.println("Error occured: " + e.getMessage());
            return false;
        }
        // Use a Transformer for output
        TransformerFactory transformerFactory = TransformerFactory.newInstance();
        try {
            transformer = transformerFactory.newTransformer();
        }
        catch (TransformerConfigurationException e) {
            System.out.println("Transformer configuration error: " + e.getMessage());
            return false;
        }
        DOMSource source = new DOMSource(doc);
        StreamResult result = new StreamResult(fos);
        // transform source into result will do save
        try {
            transformer.transform(source, result);
        }
        catch (TransformerException e) {
            System.out.println("Error transform: " + e.getMessage());
        }
        System.out.println("XML file saved.");
        return true;
    }
}