"use client";
import Link from "next/link";
import Image from "next/image";
import { Heart, ShoppingCart, Star, Truck } from "lucide-react";
import type { Product } from "@/lib/types";
import { compactNumber, formatPrice } from "@/lib/utils";
import { useState } from "react";
import { useCurrency } from "@/components/CurrencyProvider";

export default function ProductCard({ product, compact = false }: { product: Product; compact?: boolean }) {
  const [wished, setWished] = useState(false);
  const currency = useCurrency();
  return (
    <div className="group card overflow-hidden hover:shadow-pop hover:border-brand-300 transition relative">
      <Link href={`/product/${product.id}`} className="block">
        <div className="relative aspect-square bg-surface overflow-hidden">
          {/* eslint-disable-next-line @next/next/no-img-element */}
          <img
            src={product.image}
            alt={product.title}
            className="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            loading="lazy"
          />
          {product.discount && product.discount >= 10 ? (
            <span className="absolute top-1.5 left-1.5 badge-deal">-{product.discount}%</span>
          ) : null}
          {product.badge ? (
            <span className="absolute top-1.5 right-1.5 badge-promo">{product.badge}</span>
          ) : null}
          <button
            onClick={(e) => {
              e.preventDefault();
              setWished((v) => !v);
            }}
            className="absolute bottom-1.5 right-1.5 w-7 h-7 grid place-items-center bg-white/95 border border-line rounded-sm text-ink-soft hover:text-brand-700"
            aria-label="Add to wishlist"
          >
            <Heart size={14} fill={wished ? "#7c2ae8" : "none"} stroke={wished ? "#7c2ae8" : "currentColor"} />
          </button>
        </div>
      </Link>

      <div className="p-2">
        <Link href={`/product/${product.id}`}>
          <h3 className={`text-ink leading-snug ${compact ? "text-xs line-clamp-2" : "text-sm line-clamp-2"} group-hover:text-brand-700`}>
            {product.title}
          </h3>
        </Link>

        <div className="mt-1 flex items-baseline gap-1.5">
          <span className="price text-sm">{formatPrice(product.price, currency)}</span>
          {product.originalPrice ? <span className="price-strike">{formatPrice(product.originalPrice, currency)}</span> : null}
        </div>

        <div className="mt-1 flex items-center gap-1 text-[11px] text-ink-muted">
          <span className="flex items-center gap-0.5 text-brand-700 font-semibold">
            <Star size={11} fill="currentColor" /> {product.rating.toFixed(1)}
          </span>
          <span>·</span>
          <span>{compactNumber(product.sold)} sold</span>
        </div>

        <div className="mt-1 flex items-center justify-between gap-1">
          <span className={`text-[11px] flex items-center gap-1 ${product.freeShipping ? "text-emerald-700" : "text-ink-muted"}`}>
            <Truck size={11} /> {product.shipping}
          </span>
          <button
            className="bg-brand-600 hover:bg-brand-700 text-white p-1.5 rounded-sm"
            aria-label="Add to cart"
            onClick={(e) => e.preventDefault()}
          >
            <ShoppingCart size={13} />
          </button>
        </div>
      </div>
    </div>
  );
}
