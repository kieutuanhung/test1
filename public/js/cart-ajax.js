// Thêm vào giỏ bằng AJAX, không load lại trang
(function () {
    function toast(msg, ok) {
        var el = document.createElement("div");
        el.textContent = msg;
        el.style.cssText =
            "position:fixed;top:90px;right:24px;z-index:99999;padding:12px 18px;" +
            "border-radius:8px;color:#fff;font:600 14px sans-serif;" +
            "box-shadow:0 6px 20px rgba(0,0,0,.4);transition:opacity .3s;" +
            "background:" + (ok ? "#16a34a" : "#dc2626");
        document.body.appendChild(el);
        setTimeout(function () { el.style.opacity = "0"; }, 1800);
        setTimeout(function () { el.remove(); }, 2200);
    }

    // Badge trên navigation đếm SỐ DÒNG sản phẩm (count(session("cart")))
    function updateBadge(data) {
        var link = document.querySelector("a[href$=\"/cart\"]");
        if (!link) return;
        var badge = link.querySelector(".nv-badge");
        if (!badge) {                       // lúc giỏ trống, badge chưa được render -> tạo mới
            badge = document.createElement("span");
            badge.className = "nv-badge";
            link.appendChild(badge);
        }
        badge.textContent = data.cart_lines;
    }

    document.addEventListener("submit", function (e) {
        var form = e.target;
        if (!form.matches || !form.matches("form[action*=\"/cart/add/\"]")) return;

        var fd = new FormData(form, e.submitter || undefined);
        if (fd.get("buy_now")) return; // "Mua ngay": giữ nguyên (chuyển trang thanh toán)

        e.preventDefault();
        var btn = e.submitter || form.querySelector("[type=submit]");
        if (btn) btn.disabled = true;

        fetch(form.action, {
            method: "POST",
            body: fd,
            headers: { "Accept": "application/json", "X-Requested-With": "XMLHttpRequest" },
            credentials: "same-origin"
        })
            .then(function (r) {
                if (!r.ok) throw new Error(r.status);
                return r.json();
            })
            .then(function (data) {
                updateBadge(data);
                toast(data.message, true);
            })
            .catch(function () {
                toast("Không thêm được vào giỏ, vui lòng thử lại", false);
            })
            .finally(function () {
                if (btn) btn.disabled = false;
            });
    });
})();
