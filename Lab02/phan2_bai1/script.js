const input = document.getElementById("todo-input");
const addBtn = document.getElementById("add-btn");
const list = document.getElementById("todo-list");

const emptyState = document.getElementById("emptyState");
const totalEl = document.getElementById("totalTasks");
const completedEl = document.getElementById("completedTasks");
const pendingEl = document.getElementById("pendingTasks");

function updateStats() {
  const total = list.children.length;
  const completed = list.querySelectorAll(".completed").length;
  const pending = total - completed;

  totalEl.textContent = total;
  completedEl.textContent = completed;
  pendingEl.textContent = pending;

  if (total === 0) {
    emptyState.style.display = "block";
  } else {
    emptyState.style.display = "none";
  }
}

function createTodoItem(text) {
  const li = document.createElement("li");
  li.className =
    "list-group-item d-flex align-items-center justify-content-between gap-3";

  const span = document.createElement("span");
  span.className = "todo-text";
  span.textContent = text;

  const delBtn = document.createElement("button");
  delBtn.className = "btn btn-outline-danger btn-sm";
  delBtn.type = "button";
  delBtn.textContent = "Xóa";

  li.appendChild(span);
  li.appendChild(delBtn);

  li.addEventListener("click", () => {
    li.classList.toggle("completed");
    updateStats();
  });

  delBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    li.remove();
    updateStats();
  });

  return li;
}

function addTodo() {
  const text = input.value.trim();
  if (!text) {
    input.focus();
    return;
  }

  const li = createTodoItem(text);
  list.appendChild(li);

  input.value = "";
  input.focus();
  updateStats();
}

addBtn.addEventListener("click", addTodo);
input.addEventListener("keydown", (e) => {
  if (e.key === "Enter") addTodo();
});

updateStats();
