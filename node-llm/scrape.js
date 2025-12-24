import axios from "axios";
import * as cheerio from "cheerio";


export async function scrapeArticle(url) {
  const { data } = await axios.get(url);
  const $ = cheerio.load(data);

  const paragraphs = $("p")
    .map((_, el) => $(el).text())
    .get()
    .filter(p => p.length > 80);

  return paragraphs.join("\n\n");
}
