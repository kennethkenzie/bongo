import { api } from "@/lib/api";
import { formatPrice, compactNumber } from "@/lib/utils";
import ProductGrid from "@/components/product/ProductGrid";
import SectionHeader from "@/components/home/SectionHeader";
import Reviews from "@/components/product/Reviews";
import QandA from "@/components/product/QandA";
import { Store } from "lucide-react";
import { Heart, ShoppingCart, Star, Truck, ShieldCheck, RotateCcw, ChevronRight } from "lucide-react";
import Link from "next/link";
import { notFound } from "next/navigation";

export default async function ProductPage({ params }: { params: { id: string } }) {
  const [product, currency, home] = await Promise.all([api.product(params.id), api.currency(), api.home()]);
  const recommended = home.recommended;
  if (!product) return notFound();
  return (
    <div>
      <nav className="text-xs text-ink-muted flex items-center gap-1 mb-3">
        <Link href="/" className="hover:text-brand-700">Home</Link>
        <ChevronRight size={12} />
        {product.category ? (
          <Link href={`/category/${product.category}`} className="hover:text-brand-700 capitalize">
            {product.categoryName ?? product.category.replace(/-/g, " ")}
          </Link>
        ) : (
          <span>Product</span>
        )}
        <ChevronRight size={12} />
        <span className="text-ink line-clamp-1">{product.title}</span>
      </nav>

      <div className="card p-3 md:p-4 grid grid-cols-1 md:grid-cols-12 gap-4">
        <div className="md:col-span-5">
          <div className="aspect-square overflow-hidden border border-line rounded-sm bg-surface">
            {/* eslint-disable-next-line @next/next/no-img-element */}
            <img src={product.image} alt={product.title} className="w-full h-full object-cover" />
          </div>
          <div className="mt-2 grid grid-cols-5 gap-2">
            {Array.from({ length: 5 }).map((_, i) => (
              <div key={i} className={`aspect-square overflow-hidden border rounded-sm ${i === 0 ? "border-brand-600" : "border-line"}`}>
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src={product.image} alt="" className="w-full h-full object-cover" />
              </div>
            ))}
          </div>
        </div>

        <div className="md:col-span-7 space-y-3">
          {product.badge ? <span className="badge-promo">{product.badge}</span> : null}
          <h1 className="text-lg md:text-xl font-semibold text-ink">{product.title}</h1>
          <div className="flex items-center gap-3 text-xs text-ink-muted">
            <span className="flex items-center gap-0.5 text-brand-700 font-semibold">
              <Star size={12} fill="currentColor" /> {product.rating.toFixed(1)}
            </span>
            <span>{compactNumber(product.sold)} sold</span>
            <span>{Math.round(product.sold / 15)} reviews</span>
          </div>

          <div className="bg-surface p-3 rounded-sm border border-line">
            <div className="flex items-baseline gap-2">
              <span className="text-2xl font-extrabold text-deal">{formatPrice(product.price, currency)}</span>
              {product.originalPrice ? (
                <span className="text-sm text-ink-muted line-through">{formatPrice(product.originalPrice, currency)}</span>
              ) : null}
              {product.discount ? <span className="badge-deal">-{product.discount}%</span> : null}
            </div>
            <div className="text-xs text-ink-muted mt-1">Tax included. Shipping calculated at checkout.</div>
          </div>

          <div className="space-y-2 text-sm">
            <div className="flex items-center gap-2"><Truck size={14} className="text-emerald-700" /> {product.shipping}</div>
            <div className="flex items-center gap-2"><ShieldCheck size={14} className="text-brand-700" /> Buyer Protection guarantee</div>
            <div className="flex items-center gap-2"><RotateCcw size={14} className="text-ink-soft" /> Free returns within 30 days</div>
          </div>

          <div>
            <div className="text-xs text-ink-muted mb-1">Color</div>
            <div className="flex items-center gap-2">
              {["#7c2ae8", "#222", "#ddd", "#ff3b30", "#1e90ff"].map((c, i) => (
                <button key={c} className={`w-7 h-7 rounded-sm border ${i === 0 ? "border-brand-600" : "border-line"}`} style={{ background: c }} />
              ))}
            </div>
          </div>

          <div>
            <div className="text-xs text-ink-muted mb-1">Size</div>
            <div className="flex items-center gap-2 flex-wrap">
              {["S", "M", "L", "XL", "XXL"].map((s, i) => (
                <button key={s} className={`chip min-w-[40px] justify-center ${i === 1 ? "border-brand-600 text-brand-700 bg-brand-50" : ""}`}>{s}</button>
              ))}
            </div>
          </div>

          <div className="flex items-center gap-2 pt-2">
            <button className="btn-brand flex-1"><ShoppingCart size={16} className="mr-2" /> Add to Cart</button>
            <button className="btn-outline flex-1">Buy Now</button>
            <button className="w-10 h-10 grid place-items-center border border-line rounded-sm hover:text-brand-700"><Heart size={18} /></button>
          </div>
        </div>
      </div>

      <section className="card p-3 md:p-4 mt-3 flex items-center gap-3">
        <div className="w-12 h-12 rounded-sm bg-brand-600 text-white grid place-items-center font-extrabold">B</div>
        <div>
          <div className="font-semibold">Bongo Premium Store</div>
          <div className="text-xs text-ink-muted">98.3% positive feedback · 12K followers</div>
        </div>
        <Link href="/store/1" className="btn-outline ml-auto text-sm py-1.5"><Store size={14} className="mr-2" /> Visit Store</Link>
      </section>

      <Reviews rating={product.rating} sold={product.sold} />
      <QandA />

      <SectionHeader title="You may also like" href="#" />
      <ProductGrid products={recommended} cols="dense" compact />
    </div>
  );
}
