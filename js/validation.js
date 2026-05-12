// ================================================
// Native JS Validasyon — Buton 1
// ================================================

function showError(inputId, hataId, mesaj) {
  const input = document.getElementById(inputId);
  const hata = document.getElementById(hataId);
  if (input) {
    input.classList.add("is-invalid");
    input.classList.remove("is-valid");
  }
  if (hata) {
    hata.textContent = mesaj;
    hata.style.display = "block";
  }
}

function showSuccess(inputId) {
  const input = document.getElementById(inputId);
  if (input) {
    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
  }
  const hata = document.getElementById(inputId + "Hata");
  if (hata) {
    hata.textContent = "";
    hata.style.display = "none";
  }
}

function clearAllErrors() {
  document.querySelectorAll(".form-control, .form-select").forEach((el) => {
    el.classList.remove("is-invalid", "is-valid");
  });
  document.querySelectorAll(".invalid-feedback, .text-danger").forEach((el) => {
    el.textContent = "";
    el.style.display = "none";
  });
}

function emailGecerliMi(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
}

function telefonGecerliMi(tel) {
  return /^[0-9]{10,11}$/.test(tel.replace(/[\s\-]/g, ""));
}

function jsIleDogrula() {
  clearAllErrors();
  let gecerli = true;

  const ad = document.getElementById("ad").value.trim();
  if (!ad) {
    showError("ad", "adHata", "⚠ Ad boş bırakılamaz.");
    gecerli = false;
  } else if (ad.length < 2) {
    showError("ad", "adHata", "⚠ Ad en az 2 karakter olmalı.");
    gecerli = false;
  } else showSuccess("ad");

  const soyad = document.getElementById("soyad").value.trim();
  if (!soyad) {
    showError("soyad", "soyadHata", "⚠ Soyad boş bırakılamaz.");
    gecerli = false;
  } else if (soyad.length < 2) {
    showError("soyad", "soyadHata", "⚠ Soyad en az 2 karakter olmalı.");
    gecerli = false;
  } else showSuccess("soyad");

  const email = document.getElementById("email").value.trim();
  if (!email) {
    showError("email", "emailHata", "⚠ E-posta boş bırakılamaz.");
    gecerli = false;
  } else if (!emailGecerliMi(email)) {
    showError("email", "emailHata", "⚠ Geçerli e-posta giriniz.");
    gecerli = false;
  } else showSuccess("email");

  const telefon = document.getElementById("telefon").value.trim();
  if (!telefon) {
    showError("telefon", "telefonHata", "⚠ Telefon boş bırakılamaz.");
    gecerli = false;
  } else if (!telefonGecerliMi(telefon)) {
    showError("telefon", "telefonHata", "⚠ Telefon 10-11 rakamdan oluşmalı.");
    gecerli = false;
  } else showSuccess("telefon");

  const konu = document.getElementById("konu").value;
  if (!konu) {
    showError("konu", "konuHata", "⚠ Konu seçiniz.");
    gecerli = false;
  } else showSuccess("konu");

  const tercih = document.querySelector(
    'input[name="iletisimTercihi"]:checked',
  );
  const tercihHata = document.getElementById("tercihHata");
  if (!tercih) {
    if (tercihHata) {
      tercihHata.textContent = "⚠ İletişim tercihi seçiniz.";
      tercihHata.style.display = "block";
    }
    gecerli = false;
  } else {
    if (tercihHata) tercihHata.textContent = "";
  }

  const ilgiSecili = document.querySelectorAll(
    'input[name="ilgiAlanlari[]"]:checked',
  );
  const ilgiHata = document.getElementById("ilgiHata");
  if (ilgiSecili.length === 0) {
    if (ilgiHata) {
      ilgiHata.textContent = "⚠ En az bir ilgi alanı seçiniz.";
      ilgiHata.style.display = "block";
    }
    gecerli = false;
  } else {
    if (ilgiHata) ilgiHata.textContent = "";
  }

  const mesajEl = document.getElementById("mesaj");
  if (mesajEl) {
    const mesaj = mesajEl.value.trim();
    if (!mesaj) {
      showError("mesaj", "mesajHata", "⚠ Mesaj boş bırakılamaz.");
      gecerli = false;
    } else if (mesaj.length < 10) {
      showError("mesaj", "mesajHata", "⚠ Mesaj en az 10 karakter olmalı.");
      gecerli = false;
    } else showSuccess("mesaj");
  }

  const kvkk = document.getElementById("kvkk");
  const kvkkHata = document.getElementById("kvkkHata");
  if (kvkk && !kvkk.checked) {
    if (kvkkHata) {
      kvkkHata.textContent = "⚠ KVKK metnini kabul etmeniz gerekmektedir.";
      kvkkHata.style.display = "block";
    }
    gecerli = false;
  } else {
    if (kvkkHata) {
      kvkkHata.textContent = "";
      kvkkHata.style.display = "none";
    }
  }

  if (gecerli) {
    document.getElementById("iletisimForm").submit();
  } else {
    const ilkHata = document.querySelector(".is-invalid");
    if (ilkHata) {
      ilkHata.scrollIntoView({ behavior: "smooth", block: "center" });
      ilkHata.focus();
    }
  }

  return gecerli;
}

console.log("✅ validation.js yüklendi.");
