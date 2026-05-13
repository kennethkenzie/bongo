"use client";
import type { Product } from "@/lib/types";
import ProductCard from "@/components/product/ProductCard";
import { useRef } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

export default function HorizontalRail({ products }: { products: Product[] }) {
  const ref = useRef<HTMLDivElement>(null);
  const scroll = (dir: 1 | -1) => {
    if (!ref.current) return;
    ref.current.scrollBy({ left: dir * 600, behavior: "smooth" });
  };
  return (
    <div className="relative">
      <button
        onClick={() => scroll(-1)}
        className="hidden md:grid absolute -left-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 place-items-center bg-white border border-line shadow-card rounded-sm hover:bg-brand-50"
        aria-label="Scroll left"
      >
        <ChevronLeft size={16} />
      </button>
      <div ref={ref} className="scroll-x hide-scrollbar">
        {products.map((p) => (
          <div key={p.id} className="w-[150px] md:w-[180px] shrink-0">
            <ProductCard product={p} compact />
          </div>
        ))}
      </div>
      <button
        onClick={() => scroll(1)}
        className="hidden md:grid absolute -right-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 place-items-center bg-white border border-line shadow-card rounded-sm hover:bg-brand-50"
        aria-label="Scroll right"
      >
        <ChevronRight size={16} />
      </button>
    </div>
  );
}
