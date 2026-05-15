import ProductGrid from "@/components/product/ProductGrid";
import SectionHeader from "@/components/home/SectionHeader";
import { api } from "@/lib/api";

export default async function WishlistPage() {
  const { recommended, trending } = await api.home();
  return (
    <div>
      <h1 className="text-xl md:text-2xl font-bold mb-3">My Wishlist</h1>
      <ProductGrid products={recommended.slice(0, 10)} />
      <SectionHeader title="Inspired by your wishlist" href="#" />
      <ProductGrid products={trending} cols="dense" compact />
    </div>
  );
}
