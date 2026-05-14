import Link from "next/link";
import { CheckCircle2, Package, Home } from "lucide-react";

export default function SuccessPage() {
  const orderNumber = "EBO-" + Math.random().toString(36).slice(2, 12).toUpperCase();
  return (
    <div className="max-w-xl mx-auto text-center py-10">
      <div className="w-16 h-16 mx-auto bg-brand-50 text-brand-700 rounded-sm grid place-items-center">
        <CheckCircle2 size={40} />
      </div>
      <h1 className="text-2xl font-extrabold mt-4">Order placed successfully!</h1>
      <p className="text-ink-muted mt-1">Thanks for shopping at Estate Bongo Online.</p>

      <div className="card p-4 mt-6 text-left">
        <div className="text-xs text-ink-muted">Order number</div>
        <div className="font-mono font-bold text-lg text-brand-700">{orderNumber}</div>
        <div className="border-t border-line my-3" />
        <div className="flex items-start gap-2 text-sm text-ink-soft">
          <Package size={16} className="text-brand-700 mt-0.5" />
          <div>
            Your items will be processed within 24 hours. You can track your order any time from your account.
          </div>
        </div>
      </div>

      <div className="flex items-center justify-center gap-2 mt-6">
        <Link href="/account" className="btn-outline"><Package size={14} className="mr-2" /> View My Orders</Link>
        <Link href="/" className="btn-brand"><Home size={14} className="mr-2" /> Continue Shopping</Link>
      </div>
    </div>
  );
}
