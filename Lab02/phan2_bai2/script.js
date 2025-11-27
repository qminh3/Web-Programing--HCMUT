const byId = (id) => document.getElementById(id);
const numAEl = byId("numA");
const numBEl = byId("numB");
const resultEl = byId("result");
const formErrorEl = byId("formError");
const formEl = byId("calcForm");

let lastOp = null;

function parseNumber(value) {
  const s = String(value).trim().replace(",", ".");
  const n = Number(s);
  return Number.isFinite(n) ? n : NaN;
}

function showFormError(msg) {
  formErrorEl.textContent = msg;
  formErrorEl.classList.remove("d-none");
}

function clearFormError() {
  formErrorEl.classList.add("d-none");
  formErrorEl.textContent = "";
}

function validateInputs() {
  clearFormError();

  const a = parseNumber(numAEl.value);
  const b = parseNumber(numBEl.value);

  const aOk = Number.isFinite(a);
  const bOk = Number.isFinite(b);

  numAEl.classList.toggle("is-invalid", !aOk);
  numBEl.classList.toggle("is-invalid", !bOk);

  if (!aOk || !bOk) {
    showFormError(
      "Giá trị nhập phải là số hợp lệ (dùng dấu chấm hoặc phẩy cho số thập phân)."
    );
    return { ok: false };
  }
  return { ok: true, a, b };
}

function formatNumber(n) {
  const s =
    Math.abs(n) >= 1e12 || (Math.abs(n) > 0 && Math.abs(n) < 1e-6)
      ? n.toExponential(6)
      : n.toFixed(12);
  return s.replace(/\.?0+($|e)/i, "$1");
}

function calculate(op) {
  const v = validateInputs();
  if (!v.ok) return;

  const { a, b } = v;
  let res;

  switch (op) {
    case "add":
      res = a + b;
      break;
    case "sub":
      res = a - b;
      break;
    case "mul":
      res = a * b;
      break;
    case "div":
      if (b === 0) {
        showFormError("Không thể chia cho 0.");
        resultEl.textContent = "—";
        return;
      }
      res = a / b;
      break;
    case "pow":
      res = Math.pow(a, b);
      break;
    default:
      return;
  }

  resultEl.textContent = formatNumber(res);
  lastOp = op;
}

document.querySelectorAll(".btn-op").forEach((btn) => {
  btn.addEventListener("click", () => {
    clearFormError();
    calculate(btn.dataset.op);
  });
});

formEl?.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
    calculate(lastOp || "add");
  }
});

formEl?.addEventListener("reset", () => {
  clearFormError();
  numAEl.classList.remove("is-invalid");
  numBEl.classList.remove("is-invalid");
  resultEl.textContent = "—";
  lastOp = null;
});
