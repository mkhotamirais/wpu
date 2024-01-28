const express = require("express");
const expressLayouts = require("express-ejs-layouts");
const {
  loadContact,
  findContact,
  addContact,
  cekDuplikat,
} = require("./utils/contacts.js");
const { body, check, validationResult } = require("express-validator");
const app = express();

app.set("view engine", "ejs");
app.use(expressLayouts);
app.use(express.static("public"));
app.use(express.urlencoded({ extended: true }));

app.get("/", (req, res) => {
  res.render("index", { layout: "main-layout", title: "beranda" });
});

app.get("/about", (req, res) => {
  res.render("about", { layout: "main-layout", title: "about" });
});

app.get("/mahasiswa", (req, res) => {
  const mahasiswa = [
    {
      nama: "ahmad",
      umur: 20,
    },
    {
      nama: "abdul",
      umur: 21,
    },
    {
      nama: "siti",
      umur: 22,
    },
  ];
  res.render("mahasiswa", {
    layout: "main-layout",
    title: "mahasiswa",
    mahasiswa,
  });
});

app.get("/contact", (req, res) => {
  const contacts = loadContact();
  res.render("contact", {
    layout: "main-layout",
    title: "daftar contact",
    contacts,
  });
});

// halaman form tambah data kontak
app.get("/contact/add", (req, res) => {
  res.render("add-contact", {
    layout: "main-layout",
    title: "form tambah data kontak",
  });
});

// proses data kontak
app.post(
  "/contact",
  body("nama").custom((value) => {
    const duplikat = cekDuplikat(value);
    if (duplikat) {
      throw new Error("Nama contact sudah digunakan");
    }
    return true;
  }),
  check("email", "email tidak valid").isEmail(),
  check("noHp", "no hp tidak valid").isMobilePhone("id-ID"),
  (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      // return res.status(400).json({ errors: errors.array() });
      res.render("add-contact", {
        title: "form tambah data contact",
        layout: "main-layout",
        errors: errors.array(),
      });
    } else {
      addContact(req.body);
      res.redirect("/contact");
    }
  }
);

// halaman detail contact
app.get("/contact/:nama", (req, res) => {
  const contact = findContact(req.params.nama);
  res.render("detail", {
    layout: "main-layout",
    title: "detail contact",
    contact,
  });
});

app.use("/", (req, res) => {
  res.status(404);
  res.send("<h1>404</h1>");
});

app.listen(3000, () => {
  console.log("App listening on port 3000");
});
