"use client";
import { flashDeals } from "@/lib/data";
import { formatPrice } from "@/lib/utils";
import { ShieldCheck, Truck, CreditCard, Wallet, Smartphone, Building2 } from "lucide-react";
import Link from "next/link";
import { useState } from "react";

const items = flashDeals.slice(0, 3).map((p, i) => ({ ...p, qty: i + 1 }));

const payMethods = [
  { id: "card", label: "Credit / Debit Card", icon: CreditCard, desc: "Visa, MasterCard, AMEX" },
  { id: "paypal", label: "PayPal", icon: Wallet, desc: "Pay with your PayPal balance" },
  { id: "mpesa", label: "M-Pesa", icon: Smartphone, desc: "Mobile money in Kenya & Tanzania" },
  { id: "bank", label: "Bank Transfer", icon: Building2, desc: "Pay via direct deposit" },
];

export default function CheckoutPage() {
  const [pay, setPay] = useState("card");
  const subtotal = items.reduce((s, p) => s + p.price * p.qty, 0);
  const shipping = subtotal > 50 ? 0 : 4.99;
  const tax = +(subtotal * 0.08).toFixed(2);
  const total = subtotal + shipping + tax - 2.5;

  return (
    <div>
      <h1 className="text-xl md:text-2xl font-bold mb-3">Checkout</h1>
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-3">
        <div className="lg:col-span-2 space-y-3">
          {/* Address */}
          <section className="card p-4">
            <div className="flex items-center justify-between mb-3">
              <h2 className="font-bold">1. Shipping Address</h2>
              <button className="text-brand-700 text-sm hover:underline">+ Add new</button>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
              <input className="border border-line rounded-sm px-3 py-2" placeholder="Full name" defaultValue="Kenneth Kenzie" />
              <input className="border border-line rounded-sm px-3 py-2" placeholder="Phone" defaultValue="+255 700 000 000" />
              <input className="border border-line rounded-sm px-3 py-2 md:col-span-2" placeholder="Street address" defaultValue="123 Bongo Street" />
              <input className="border border-line rounded-sm px-3 py-2" placeholder="City" defaultValue="Dar es Salaam" />
              <input className="border border-line rounded-sm px-3 py-2" placeholder="Region / State" defaultValue="Dar es Salaam" />
              <input className="border border-line rounded-sm px-3 py-2" placeholder="Postal code" defaultValue="11101" />
              <select className="border border-line rounded-sm px-3 py-2 bg-white">
                <option>Tanzania</option><option>Kenya</option><option>Uganda</option><option>Rwanda</option><option>United States</option>
              </select>
            </div>
          </section>

          {/* Shipping */}
          <section className="card p-4">
            <h2 className="font-bold mb-3">2. Shipping Method</h2>
            <div className="space-y-2 text-sm">
              {[
                { id: "std", label: "Standard Shipping", eta: "7–14 days", price: shipping },
                { id: "exp", label: "Express Shipping", eta: "3–5 days", price: 9.99 },
                { id: "next", label: "Premium Delivery", eta: "1–2 days", price: 19.99 },
              ].map((s, i) => (
                <label key={s.id} className={`flex items-center gap-3 border rounded-sm p-3 cursor-pointer ${i === 0 ? "border-brand-600 bg-brand-50" : "border-line"}`}>
                  <input type="radio" name="ship" defaultChecked={i === 0} className="accent-brand-600" />
                  <Truck size={16} className="text-brand-700" />
                  <div className="flex-1">
                    <div className="font-medium">{s.label}</div>
                    <div className="text-xs text-ink-muted">Estimated arrival: {s.eta}</div>
                  </div>
                  <div className="font-semibold">{s.price === 0 ? "FREE" : formatPrice(s.price)}</div>
                </label>
              ))}
            </div>
          </section>

          {/* Payment */}
          <section className="card p-4">
            <h2 className="font-bold mb-3">3. Payment Method</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
              {payMethods.map((m) => {
                const Icon = m.icon;
                const active = pay === m.id;
                return (
                  <label key={m.id} className={`flex items-center gap-3 border rounded-sm p-3 cursor-pointer ${active ? "border-brand-600 bg-brand-50" : "border-line"}`}>
                    <input type="radio" name="pay" checked={active} onChange={() => setPay(m.id)} className="accent-brand-600" />
                    <Icon size={18} className="text-brand-700" />
                    <div className="flex-1">
                      <div className="font-medium">{m.label}</div>
                      <div className="text-xs text-ink-muted">{m.desc}</div>
                    </div>
                  </label>
                );
              })}
            </div>

            {pay === "card" && (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm mt-3">
                <input className="border border-line rounded-sm px-3 py-2 md:col-span-2" placeholder="Card number" />
                <input className="border border-line rounded-sm px-3 py-2" placeholder="MM / YY" />
                <input className="border border-line rounded-sm px-3 py-2" placeholder="CVC" />
                <input className="border border-line rounded-sm px-3 py-2 md:col-span-2" placeholder="Cardholder name" />
              </div>
            )}
          </section>

          {/* Items */}
          <section className="card p-4">
            <h2 className="font-bold mb-3">4. Order Items ({items.length})</h2>
            <div className="space-y-3">
              {items.map((p) => (
                <div key={p.id} className="flex gap-3">
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img src={p.image} alt={p.title} className="w-16 h-16 object-cover rounded-sm border border-line" />
                  <div className="flex-1 text-sm">
                    <div className="line-clamp-2">{p.title}</div>
                    <div className="text-xs text-ink-muted">Qty: {p.qty}</div>
                  </div>
                  <div className="text-sm price">{formatPrice(p.price * p.qty)}</div>
                </div>
              ))}
            </div>
          </section>
        </div>

        {/* Summary */}
        <aside className="space-y-2">
          <div className="card p-4 lg:sticky lg:top-24">
            <h3 className="font-bold mb-3">Order Summary</h3>
            <div className="space-y-1.5 text-sm">
              <div className="flex justify-between"><span className="text-ink-muted">Subtotal</span><span>{formatPrice(subtotal)}</span></div>
              <div className="flex justify-between"><span className="text-ink-muted">Shipping</span><span>{shipping === 0 ? "FREE" : formatPrice(shipping)}</span></div>
              <div className="flex justify-between"><span className="text-ink-muted">Estimated Tax</span><span>{formatPrice(tax)}</span></div>
              <div className="flex justify-between"><span className="text-ink-muted">Coupon</span><span className="text-brand-700">- {formatPrice(2.5)}</span></div>
              <div className="border-t border-line my-2" />
              <div className="flex justify-between font-bold text-base"><span>Total</span><span className="text-deal">{formatPrice(total)}</span></div>
            </div>
            <Link href="/checkout/success" className="btn-brand w-full mt-3">Place Order</Link>
            <div className="text-[11px] text-ink-muted flex items-center gap-1 justify-center mt-2">
              <ShieldCheck size={12} /> Secure checkout · Buyer Protection
            </div>
          </div>
        </aside>
      </div>
    </div>
  );
}
