import { flashDeals, recommended } from "@/lib/data";
import { formatPrice } from "@/lib/utils";
import ProductGrid from "@/components/product/ProductGrid";
import SectionHeader from "@/components/home/SectionHeader";
import { Trash2, Minus, Plus, ShieldCheck } from "lucide-react";
import Link from "next/link";


const cartItems = flashDeals.slice(0, 5).map((p, i) => ({ ...p, qty: i + 1 }));

export default function CartPage() {
  const subtotal = cartItems.reduce((s, p) => s + p.price * p.qty, 0);
  const shipping = subtotal > 50 ? 0 : 4.99;
  return (
    <div>
      <h1 className="text-xl md:text-2xl font-bold mb-3">Shopping Cart ({cartItems.length})</h1>
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-3">
        <div className="lg:col-span-2 space-y-2">
          <div className="card p-3 flex items-center gap-3 text-sm">
            <input type="checkbox" defaultChecked className="accent-brand-600" />
            <span className="font-medium">Select all</span>
            <button className="ml-auto text-ink-muted hover:text-deal flex items-center gap-1 text-xs"><Trash2 size={12} /> Remove selected</button>
          </div>
          {cartItems.map((p) => (
            <div key={p.id} className="card p-3 flex gap-3">
              <input type="checkbox" defaultChecked className="accent-brand-600 mt-1" />
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src={p.image} alt={p.title} className="w-20 h-20 object-cover rounded-sm border border-line" />
              <div className="flex-1">
                <Link href={`/product/${p.id}`} className="text-sm hover:text-brand-700 line-clamp-2">{p.title}</Link>
                <div className="text-xs text-ink-muted mt-1">Color: Purple · Size: M</div>
                <div className="mt-2 flex items-center justify-between">
                  <div className="flex items-center border border-line rounded-sm">
                    <button className="w-7 h-7 grid place-items-center hover:bg-surface"><Minus size={12} /></button>
                    <span className="w-8 text-center text-sm">{p.qty}</span>
                    <button className="w-7 h-7 grid place-items-center hover:bg-surface"><Plus size={12} /></button>
                  </div>
                  <div className="text-right">
                    <div className="price">{formatPrice(p.price * p.qty)}</div>
                    <div className="text-[11px] text-ink-muted">{formatPrice(p.price)} each</div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
        <aside className="space-y-2">
          <div className="card p-4">
            <h3 className="font-bold mb-3">Order Summary</h3>
            <div className="space-y-1.5 text-sm">
              <div className="flex justify-between"><span className="text-ink-muted">Subtotal</span><span>{formatPrice(subtotal)}</span></div>
              <div className="flex justify-between"><span className="text-ink-muted">Shipping</span><span>{shipping === 0 ? "FREE" : formatPrice(shipping)}</span></div>
              <div className="flex justify-between"><span className="text-ink-muted">Coupon</span><span className="text-brand-700">- {formatPrice(2.50)}</span></div>
              <div className="border-t border-line my-2" />
              <div className="flex justify-between font-bold text-base"><span>Total</span><span className="text-deal">{formatPrice(subtotal + shipping - 2.5)}</span></div>
            </div>
            <Link href="/checkout" className="btn-brand w-full mt-3">Proceed to Checkout</Link>
            <div className="text-[11px] text-ink-muted flex items-center gap-1 justify-center mt-2">
              <ShieldCheck size={12} /> Secure checkout · Buyer Protection
            </div>
          </div>
          <div className="card p-3">
            <input placeholder="Enter coupon code" className="w-full border border-line rounded-sm px-2 py-1.5 text-sm" />
            <button className="btn-outline w-full mt-2 py-1.5 text-sm">Apply coupon</button>
          </div>
        </aside>
      </div>
      <SectionHeader title="People also bought" href="#" />
      <ProductGrid products={recommended.slice(0, 10)} cols="dense" compact />
    </div>
  );
}
