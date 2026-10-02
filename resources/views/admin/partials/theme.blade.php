{{--
    Giao diện sáng hơn cho các trang admin (sản phẩm, danh mục, thùng rác, form thêm/sửa).
    Dùng selector "body .xxx" để ghi đè khối <style> riêng của từng trang,
    nên KHÔNG cần sửa từng file blade.
--}}
<style>
    /* ===== Nền trang: xám than + quầng đỏ/cam nhẹ ===== */
    body .bg-ink.min-h-screen {
        background:
            radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
            radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
            #151519;
    }

    /* ===== Khối (card) ===== */
    body .ad-card {
        background: linear-gradient(180deg, #1f1f26, #19191f);
        border: 1px solid #2e2e37;
        box-shadow: 0 6px 24px rgba(0,0,0,.25);
    }

    /* ===== Form ===== */
    body .ad-label { color: #b8b8c2; }
    body .ad-hint  { color: #a8a8b3; }
    body .ad-input {
        background-color: #23232b;
        border-color: #3b3b47;
        color: #fff;
    }
    body .ad-input::placeholder { color: #8d8d99; }
    body .ad-input:focus {
        border-color: #ff5a4d;
        box-shadow: 0 0 0 3px rgba(255,90,77,.22);
    }
    body .ad-file::file-selector-button { background-color: #34343e; color: #f1f1f4; }
    body .ad-file::file-selector-button:hover { background-color: #43434f; }

    /* ===== Nút ===== */
    body .ad-btn-red {
        background: linear-gradient(135deg, #ff5a4d, #e0392c);
        box-shadow: 0 4px 14px rgba(224,57,44,.35);
        transition: transform .15s, box-shadow .15s, filter .15s;
    }
    body .ad-btn-red:hover {
        background: linear-gradient(135deg, #ff6b5f, #e8443a);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(224,57,44,.45);
    }
    body .ad-btn-ghost { border-color: #4a4a57; color: #dcdce2; }
    body .ad-btn-ghost:hover { border-color: #ff8a80; color: #fff; background-color: rgba(255,255,255,.05); }

    /* ===== Bảng ===== */
    body .ad-tbl th {
        color: #b8b8c2;
        background-color: rgba(255,255,255,.035);
        border-bottom-color: #3b3b47;
    }
    body .ad-tbl td { color: #e6e6ea; border-bottom-color: #2e2e37; }
    body .ad-tbl tbody tr:hover { background-color: rgba(255,99,88,.07); }

    /* ===== Nút hành động trong bảng ===== */
    body .ad-act { border-color: #4a4a57; color: #e6e6ea; }
    body .ad-act:hover { border-color: #fff; background-color: rgba(255,255,255,.07); }
    body .ad-act-red { color: #ff8a80; border-color: rgba(255,138,128,.5); }
    body .ad-act-red:hover { background-color: rgba(255,138,128,.15); border-color: #ff8a80; color: #ffa59d; }
    body .ad-act-green { color: #4ade80; border-color: rgba(74,222,128,.5); }
    body .ad-act-green:hover { background-color: rgba(74,222,128,.15); border-color: #4ade80; color: #86efac; }

    /* ===== Chip / size ===== */
    body .ad-size { background-color: #2a2a33; border-color: #43434f; color: #f1f1f4; }
    body .ad-chip { font-size: 10.5px; }
</style>
